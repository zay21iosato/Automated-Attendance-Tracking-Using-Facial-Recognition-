import subprocess
from flask import Flask, jsonify, render_template, request, redirect, url_for
import os
import mysql.connector
import base64
from PIL import Image
from io import BytesIO
import os
import base64
import pickle
import numpy as np
import pandas as pd
from io import BytesIO
from flask import Flask, request, jsonify
from PIL import Image
import face_recognition_api
import json
import requests

app = Flask(__name__)


config = {
    "user": "root",
    "password": "",
    "host": "localhost",
    "database": "open",
    "raise_on_warnings": True,
}


@app.route("/")
def index():
    try:

        conn = mysql.connector.connect(**config)

        cursor = conn.cursor()

        query = "SELECT student_id, name FROM student"

        cursor.execute(query)

        result = cursor.fetchall()

    except mysql.connector.Error as err:
        result = []
        print(f"Error: {err}")

    finally:
        cursor.close()
        conn.close()

    return render_template("index.html", students=result)


@app.route("/face-login")
def administator():
    try:

        conn = mysql.connector.connect(**config)

        cursor = conn.cursor()

        query = "SELECT email, name FROM admin"

        cursor.execute(query)

        result = cursor.fetchall()
    except mysql.connector.Error as err:
        result = []
        print(f"Error: {err}")

    finally:
        cursor.close()
        conn.close()

    return render_template("login.html", administrator=result)


@app.route("/trainadmin", methods=["POST"])
def trainadmin():
    try:
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        query = "SELECT email, name FROM admin"
        cursor.execute(query)
        result = cursor.fetchall()
    except mysql.connector.Error as err:
        result = []
        print(f"Error: {err}")
    finally:
        cursor.close()
        conn.close()

    student_id = request.form["student_id"]
    images = request.files.getlist("images")

    current_dir = os.path.dirname(os.path.abspath(__file__))

    student_folder = os.path.join(current_dir, "training-images", student_id)

    if not os.path.exists(student_folder):
        os.makedirs(student_folder)

    for image in images:
        filename = image.filename
        image.save(os.path.join(student_folder, filename))

    try:
        subprocess.run(
            ["python", os.path.join(current_dir, "create_encodings.py")], check=True
        )
    except subprocess.CalledProcessError:
        return render_template(
            "login.html", success=False, message="Failed to create encodings."
        )

    try:
        subprocess.run(["python", os.path.join(current_dir, "train.py")], check=True)
    except subprocess.CalledProcessError:
        return render_template(
            "login.html", success=False, message="Failed to train model."
        )

    return render_template(
        "login.html",
        success=True,
        message="Training completed successfully.",
        administrator=result,
    )


@app.route("/train", methods=["POST"])
def train():
    try:
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        query = "SELECT student_id, name FROM student"
        cursor.execute(query)
        result = cursor.fetchall()
    except mysql.connector.Error as err:
        result = []
        print(f"Error: {err}")
    finally:
        cursor.close()
        conn.close()

    student_id = request.form["student_id"]
    images = request.files.getlist("images")

    # Get the current directory of this script
    current_directory = os.path.dirname(os.path.abspath(__file__))

    # Set the path for the training images folder
    student_folder = os.path.join(current_directory, "training-images", student_id)

    if not os.path.exists(student_folder):
        os.makedirs(student_folder)

    for image in images:
        filename = image.filename
        image.save(os.path.join(student_folder, filename))

    try:
        subprocess.run(
            ["python", os.path.join(current_directory, "create_encodings.py")],
            check=True,
        )
    except subprocess.CalledProcessError:
        return render_template(
            "index.html", success=False, message="Failed to create encodings."
        )

    try:
        subprocess.run(
            ["python", os.path.join(current_directory, "train.py")], check=True
        )
    except subprocess.CalledProcessError:
        return render_template(
            "index.html", success=False, message="Failed to train model."
        )

    return render_template(
        "index.html",
        success=True,
        message="Training completed successfully.",
        students=result,
    )


def get_prediction_images(prediction_dir):
    files = [x[2] for x in os.walk(prediction_dir)][0]
    l = []
    exts = [".jpg", ".jpeg", ".png"]
    for file in files:
        _, ext = os.path.splitext(file)
        if ext.lower() in exts:
            l.append(os.path.join(prediction_dir, file))
    return l


@app.route("/capture", methods=["POST"])
def capture():
    image_data = request.form.get("image")
    if not image_data:
        return jsonify({"status": "error", "message": "No image data received."})

    image_data = image_data.split(",")[1]
    image = Image.open(BytesIO(base64.b64decode(image_data)))
    image_path = "captured_image.jpg"
    image.save(image_path)

    fname = "classifier.pkl"

    if not os.path.isfile(fname):
        return jsonify({"status": "error", "message": "Classifier does not exist."})

    with open(fname, "rb") as f:
        le, clf = pickle.load(f)

    img = face_recognition_api.load_image_file(image_path)
    X_faces_loc = face_recognition_api.face_locations(img)
    faces_encodings = face_recognition_api.face_encodings(
        img, known_face_locations=X_faces_loc
    )

    closest_distances = clf.kneighbors(faces_encodings, n_neighbors=1)
    is_recognized = [closest_distances[0][i][0] <= 0.5 for i in range(len(X_faces_loc))]

    predictions = [
        (
            (le.inverse_transform([int(pred)])[0].title(), loc)
            if rec
            else ("Unknown", loc)
        )
        for pred, loc, rec in zip(
            clf.predict(faces_encodings), X_faces_loc, is_recognized
        )
    ]

    if not predictions:
        return jsonify(
            {
                "status": "error",
                "message": "No face detected.",
                "predictions": predictions,
            }
        )

    student_id, _ = predictions[0]
    if student_id == "Unknown":
        return jsonify(
            {
                "status": "error",
                "message": "Face is not a registered student",
                "predictions": predictions,
            }
        )

    try:
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()

        # Check if a record exists for the student with status 4 today
        sql_check = """
            SELECT status FROM attendance 
            WHERE student_id = %s AND date = CURDATE()
        """
        cursor.execute(sql_check, (student_id,))
        result = cursor.fetchone()
        response_message = "Default message"
        if result:
            if result[0] == 4:
                sql_update = """
                    UPDATE attendance SET status = 1 
                    WHERE student_id = %s AND date = CURDATE()
                """
                cursor.execute(sql_update, (student_id,))
                conn.commit()
                response_message = "Your child has Timed out"
                sendsms(student_id, response_message)

            elif result[0] == 1:
                response_message = "Student Already Attended"
        else:
            sql_insert = """
                INSERT INTO attendance (student_id, status, date) 
                VALUES (%s, %s, CURDATE())
            """
            cursor.execute(sql_insert, (student_id, 4))
            conn.commit()

            response_message = "Your child Time in Success"
            sendsms(student_id, response_message)

        return jsonify(
            {
                "status": "success",
                "message": response_message,
                "predictions": predictions,
            }
        )

    except mysql.connector.Error as err:
        print(err)
        return jsonify({"status": "error", "message": f"Database error: {err}"})

    finally:
        cursor.close()
        conn.close()


def sendsms(student_id, message):
    try:
        # Establish a connection to the database
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()

        # Fetch the parent_id from the student table based on student_id
        cursor.execute(
            "SELECT parent_id FROM student WHERE student_id = %s", (student_id,)
        )
        parent_id = cursor.fetchone()

        if not parent_id:
            print(f"No parent found for student_id: {student_id}")
            return

        # Fetch the phone number from the parent table based on parent_id
        cursor.execute("SELECT phone FROM parent WHERE parent_id = %s", (parent_id[0],))
        phone_number = cursor.fetchone()

        if not phone_number:
            print(f"No phone number found for parent_id: {parent_id[0]}")
            return

        # Prepare the data payload for PhilSMS
        payload = {
            "recipient": phone_number[0],
            "sender_id": "PhilSMS",  # Replace with your actual sender ID
            "type": "plain",
            "message": message,
        }

        # Set up the headers
        headers = {
            "Authorization": "Bearer 821|fIAkc64uhsb7YWnwMNYRsKJMKvDy0sDqAL32CJIB ",  # Replace with your actual API key
            "Content-Type": "application/json",
            "Accept": "application/json",
        }

        # Send the request to the PhilSMS API
        response = requests.post(
            "https://app.philsms.com/api/v3/sms/send",
            headers=headers,
            data=json.dumps(payload),
        )

        # Handle the response
        if response.status_code == 200:
            print("Message sent successfully")
        else:
            print(
                f"Failed to send message. Status code: {response.status_code}, Response: {response.text}"
            )

    except mysql.connector.Error as err:
        print(f"Database error: {err}")
    finally:
        cursor.close()
        conn.close()


@app.route("/captureadmin", methods=["POST"])
def captureadmin():
    image_data = request.form.get("image")
    if image_data:
        image_data = image_data.split(",")[1]
        image = Image.open(BytesIO(base64.b64decode(image_data)))
        image_path = "captured_image.jpg"
        image.save(image_path)

        fname = "classifier.pkl"
        encoding_file_path = "encoded-images-data.csv"

        df = pd.read_csv(encoding_file_path)
        full_data = np.array(df.astype(float).values.tolist())

        X = np.array(full_data[:, 1:-1])
        y = np.array(full_data[:, -1:])

        if os.path.isfile(fname):
            with open(fname, "rb") as f:
                le, clf = pickle.load(f)
        else:
            return jsonify({"status": "error", "message": "Classifier does not exist."})

        img = face_recognition_api.load_image_file(image_path)
        X_faces_loc = face_recognition_api.face_locations(img)
        faces_encodings = face_recognition_api.face_encodings(
            img, known_face_locations=X_faces_loc
        )

        closest_distances = clf.kneighbors(faces_encodings, n_neighbors=1)
        is_recognized = [
            closest_distances[0][i][0] <= 0.5 for i in range(len(X_faces_loc))
        ]

        predictions = [
            (
                (le.inverse_transform([int(pred)])[0].title(), loc)
                if rec
                else ("Unknown", loc)
            )
            for pred, loc, rec in zip(
                clf.predict(faces_encodings), X_faces_loc, is_recognized
            )
        ]
        print(predictions)

        return jsonify(
            {
                "status": "success",
                "message": "Image received, processed, and predictions made.",
                "predictions": predictions,
            }
        )

    return jsonify({"status": "error", "message": "No image received."})


if __name__ == "__main__":
    app.run(debug=True)
