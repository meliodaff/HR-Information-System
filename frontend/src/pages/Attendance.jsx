import React, { useEffect, useState } from "react";
import "../styles/Attendance.css";

const Attendance = () => {
  const [rfidData, setRfidData] = useState(null);
  const [connectionStatus, setConnectionStatus] = useState("Connecting...");
  const [attendanceHistory, setAttendanceHistory] = useState([]);
  const [popupData, setPopupData] = useState(null);
  const [showPopup, setShowPopup] = useState(false);

  useEffect(() => {
    // Connect to WebSocket server
    const socket = new WebSocket("ws://localhost:8080/rfid");

    socket.onopen = () => {
      console.log("✅ WebSocket connected");
      setConnectionStatus("Connected");
    };

    socket.onmessage = (event) => {
      try {
        const data = JSON.parse(event.data);
        console.log(event.data);
        console.log(data);
        console.log("📩 RFID scan received:", data);
        setRfidData(data);

        // Prepare popup data
        const currentTime = new Date().toTimeString().slice(0, 5);
        const popupInfo = {
          name: data.name || "",
          id: data.rfid || "",
          message: data.message || "",
          date: new Date().toISOString().split("T")[0],
          timeIn: data.timeIn ? data.timeIn.split(" ")[1] : " - ",
          timeOut: data.timeOut ? data.timeOut.split(" ")[1] : " - ",
          showTimeOut: data.type === "time_out",
        };

        setPopupData(popupInfo);
        setShowPopup(true);

        // Auto-close popup after 5 seconds
        setTimeout(() => {
          setShowPopup(false);
        }, 5000);

        // Add to history
        setAttendanceHistory((prev) => [data, ...prev]);
      } catch (err) {
        console.log(err);
        console.error("❌ Failed to parse WebSocket message:", event.data);
      }
    };

    socket.onerror = (err) => {
      console.error("⚠️ WebSocket error:", err);
      setConnectionStatus("Error");
    };

    socket.onclose = () => {
      console.log("❌ WebSocket closed");
      setConnectionStatus("Disconnected");
    };

    return () => socket.close();
  }, []);

  const handleSubmit = (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = {
      name: form.empName.value,
      id: form.empID.value,
      message: form.empMessage?.value || "",
      date: form.date.value,
      timeIn: form.timeIn.value,
      timeOut: form.timeOut.value,
      showTimeOut: !!form.timeOut.value,
    };

    setPopupData(formData);
    setShowPopup(true);

    // Reset form
    form.reset();
  };

  const closePopup = () => {
    setShowPopup(false);
  };

  return (
    <div
      className="body"
      style={{ backgroundImage: "url('/images/background.png')" }}
    >
      <div className="attendance">
        <div className="logo">
          <img src="/images/vetlogo.png" alt="Fur Ever Logo" />
          <h1>FUR EVER</h1>
        </div>

        <div className="form">
          <h2 className="title">Employee Attendance</h2>

          {/* WebSocket Status Indicator */}
          <div
            style={{
              textAlign: "center",
              marginBottom: "10px",
              padding: "8px",
              backgroundColor:
                connectionStatus === "Connected" ? "#d4edda" : "#f8d7da",
              borderRadius: "5px",
              fontSize: "14px",
            }}
          >
            <strong>RFID Status:</strong> {connectionStatus}
          </div>

          <form className="attend_form" onSubmit={handleSubmit}>
            <input
              type="text"
              id="empID"
              name="empID"
              placeholder="Employee ID"
              required
            />
            <input
              type="text"
              id="empName"
              name="empName"
              placeholder="Employee Name"
              required
            />
            <label htmlFor="date">Date</label>
            <input type="date" id="date" name="date" required />
            <div className="time-fields">
              <div className="time-field">
                <label htmlFor="timeIn">Time In</label>
                <input type="time" id="timeIn" name="timeIn" required />
              </div>
              <div className="time-field">
                <label htmlFor="timeOut">Time Out</label>
                <input type="time" id="timeOut" name="timeOut" />
              </div>
            </div>
            <button type="submit">Submit</button>
          </form>
        </div>
      </div>

      <div className="img_bg">
        <img src="/images/b.PNG" alt="background" />
      </div>

      {/* Popup - Now controlled by React state */}
      {showPopup && popupData && (
        <div className="popup" style={{ display: "flex" }}>
          <div className="popup-box">
            <span className="close" onClick={closePopup}>
              &times;
            </span>
            <div className="profile-pic">
              <img src="" alt="your profile pic" />
            </div>
            <h3>{popupData.name}</h3>
            <p
              style={{
                color: "#1d5e9e",
                fontWeight: "600",
                fontSize: "18px",
                marginBottom: "15px",
              }}
            >
              {popupData.message}
            </p>
            <p>
              <strong>ID:</strong> <span>{popupData.id}</span>
            </p>
            {/* {popupData.message && (
              <p>
                <strong>Message: </strong> <span>{popupData.message}</span>
              </p>
            )} */}
            <p>
              <strong>Date:</strong> <span>{popupData.date}</span>
            </p>
            <p>
              <strong>Time In:</strong> <span>{popupData.timeIn}</span>
            </p>
            <p>
              <strong>Time Out:</strong>{" "}
              <span>{popupData.timeOut ? popupData.timeOut : " - "}</span>
            </p>
          </div>
        </div>
      )}
    </div>
  );
};

export default Attendance;
