import React from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import { BrowserRouter } from "react-router-dom";
import Homepage from "./pages/Homepage";
import JobOffer from "./pages/Joboffer";
import Dashboard from "./pages/Dashboard";
import Applicant from "./pages/Applicant";
import JobApplicationForm from "./pages/JobApplicationForm";
import Employees from "./pages/Employees";
import AdminAnalytics from "./pages/AdminAnalytics";
import AdminSchedule from "./pages/AdminSchedule";
import AdminIncentives from "./pages/AdminIncentives";
import EmployeeAnalytics from "./pages/EmployeeAnalytics";
import EmployeeSchedule from "./pages/EmployeeSchedule";
import LeaveRequest from "./pages/LeaveRequest";
import EmployeeIncentives from "./pages/EmployeeIncentives";
import LiveRFIDDisplay from "./pages/LiveRFIDDisplay";
import LiveAttendance from "./pages/LiveAttendance";
ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <BrowserRouter>
      <EmployeeIncentives />
      {/* <Homepage /> */}
      {/* <JobOffer /> */}
      {/* <Applicant /> */}
      {/* <JobApplicationForm /> */}
      {/* <Employees /> */}
      {/* <AdminAnalytics /> */}
      {/* <AdminSchedule /> employee schedule not done yet */}
      {/* <LeaveRequest /> */}
      {/* <EmployeeIncentives /> */}
      {/* <LiveRFIDDisplay /> */}
      {/* <LiveAttendance /> */}
    </BrowserRouter>
  </React.StrictMode>
);
