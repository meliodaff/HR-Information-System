import { Routes, Route } from "react-router-dom";
import Dashboard from "./pages/Dashboard";
import Employee from "./pages/Employee";
import Applicant from "./pages/Applicant";
import Schedule from "./pages/Schedule";
import Incentives from "./pages/Incentives";
import Analytics from "./pages/Analytics";
import DashboardLayout from "./components/DashboardLayout";

export default function App() {
  return (
    <DashboardLayout>
      <Routes>
        <Route path="/dashboard" element={<Dashboard />} />
        <Route path="/employee" element={<Employee />} />
        <Route path="/applicant" element={<Applicant />} />
        <Route path="/schedule" element={<Schedule />} />
        <Route path="/incentives" element={<Incentives />} />
        <Route path="/analytics" element={<Analytics />} />
      </Routes>
    </DashboardLayout>
  );
}
