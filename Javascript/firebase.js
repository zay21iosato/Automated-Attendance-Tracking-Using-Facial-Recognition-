// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyAO4guh5BpiR0rc5mS3WH0A1h2zxAPKn1M",
  authDomain: "event-attendance-5457e.firebaseapp.com",
  databaseURL: "https://event-attendance-5457e-default-rtdb.firebaseio.com",
  projectId: "event-attendance-5457e",
  storageBucket: "event-attendance-5457e.appspot.com",
  messagingSenderId: "644049506339",
  appId: "1:644049506339:web:b876160b0648885c7a6196",
  measurementId: "G-LXVM2M504S"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);