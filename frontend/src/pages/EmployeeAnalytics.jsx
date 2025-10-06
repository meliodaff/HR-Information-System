import React, { useState } from 'react';
import EmployeeNavbar from '../components/Sections/EmployeeNavbar';

export default function EmployeeAnalytics({ employee }) {
  // Sample analytics data 
  const [analyticsData] = useState({
    attendance: {
      present: 80,
      absent: 15,
      late: 5,
      total: 100
    },
    trends: [
      { month: 'Feb', value: 15 },
      { month: 'Mar', value: 18 },
      { month: 'Apr', value: 20 },
      { month: 'May', value: 21 },
      { month: 'Jun', value: 22 },
      { month: 'Jul', value: 23 }
    ],
    rewards: {
      totalEarned: 3,
      perfectAttendance: true,
      targetMonth: 'September'
    },
    improvement: {
      percentage: 15,
      period: 'this month'
    }
  });

  // Navigation handler
  const handleNavigation = (navName) => {
    console.log('Navigate to:', navName);
  };

  // Calculate percentages for donut chart
  const total = analyticsData.attendance.total;
  const presentPercentage = (analyticsData.attendance.present / total) * 100;
  const absentPercentage = (analyticsData.attendance.absent / total) * 100;
  const latePercentage = (analyticsData.attendance.late / total) * 100;

  // SVG Donut Chart calculations
  const radius = 70;
  const circumference = 2 * Math.PI * radius;
  const presentOffset = 0;
  const absentOffset = (presentPercentage / 100) * circumference;
  const lateOffset = ((presentPercentage + absentPercentage) / 100) * circumference;

  // Find min and max for chart scaling
  const maxValue = Math.max(...analyticsData.trends.map(t => t.value));
  const minValue = Math.min(...analyticsData.trends.map(t => t.value));
  const range = maxValue - minValue;

  return (
    <>
      {/* Employee Navbar */}
      <EmployeeNavbar 
        employee={employee}
        onNavigate={handleNavigation}
      />

      {/* Main Content */}
      <div className="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
        <div className="max-w-7xl mx-auto">
          {/* Header */}
          <h1 className="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 mb-6">
            PERFORMANCE ANALYTICS
          </h1>

          {/* Main Container */}
          <div className="bg-gradient-to-br from-blue-200 via-blue-100 to-blue-50 rounded-2xl shadow-lg p-4 sm:p-6 lg:p-8">
            {/* Top Section - Analytics Cards */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
              {/* Attendance Analytics */}
              <div className="bg-white rounded-xl shadow-md p-6">
                <h2 className="text-lg sm:text-xl font-black text-gray-900 mb-6">
                  Attendance Analytics
                </h2>

                <div className="flex flex-col sm:flex-row items-center gap-6">
                  {/* Donut Chart */}
                  <div className="relative w-48 h-48 flex-shrink-0">
                    <svg className="w-full h-full transform -rotate-90" viewBox="0 0 160 160">
                      {/* Present segment (blue) */}
                      <circle
                        cx="80"
                        cy="80"
                        r={radius}
                        fill="none"
                        stroke="#6B7280"
                        strokeWidth="20"
                        strokeDasharray={`${(presentPercentage / 100) * circumference} ${circumference}`}
                        strokeDashoffset="0"
                        className="transition-all duration-500"
                      />
                      {/* Absent segment (red) */}
                      <circle
                        cx="80"
                        cy="80"
                        r={radius}
                        fill="none"
                        stroke="#EF4444"
                        strokeWidth="20"
                        strokeDasharray={`${(absentPercentage / 100) * circumference} ${circumference}`}
                        strokeDashoffset={-absentOffset}
                        className="transition-all duration-500"
                      />
                      {/* Late segment (orange) */}
                      <circle
                        cx="80"
                        cy="80"
                        r={radius}
                        fill="none"
                        stroke="#F59E0B"
                        strokeWidth="20"
                        strokeDasharray={`${(latePercentage / 100) * circumference} ${circumference}`}
                        strokeDashoffset={-lateOffset}
                        className="transition-all duration-500"
                      />
                    </svg>
                    <div className="absolute inset-0 flex items-center justify-center">
                      <div className="text-center">
                        <div className="text-3xl font-black text-gray-900">
                          {presentPercentage.toFixed(0)}%
                        </div>
                      </div>
                    </div>
                  </div>

                  {/* Legend and Description */}
                  <div className="flex-1">
                    <div className="space-y-2 mb-4">
                      <div className="flex items-center gap-2">
                        <div className="w-4 h-4 rounded-full bg-gray-600"></div>
                        <span className="text-sm font-semibold text-gray-700">Present</span>
                      </div>
                      <div className="flex items-center gap-2">
                        <div className="w-4 h-4 rounded-full bg-red-500"></div>
                        <span className="text-sm font-semibold text-gray-700">Absent</span>
                      </div>
                      <div className="flex items-center gap-2">
                        <div className="w-4 h-4 rounded-full bg-amber-500"></div>
                        <span className="text-sm font-semibold text-gray-700">Late</span>
                      </div>
                    </div>
                    <p className="text-sm text-gray-600 leading-relaxed">
                      You're <span className="font-bold">{presentPercentage.toFixed(0)}% toward Perfect Attendance</span> this month
                    </p>
                  </div>
                </div>
              </div>

              {/* Trends Chart */}
              <div className="bg-white rounded-xl shadow-md p-6">
                <h2 className="text-lg sm:text-xl font-black text-gray-900 mb-6">
                  Trends
                </h2>

                {/* Line Chart */}
                <div className="relative h-48">
                  <svg className="w-full h-full" viewBox="0 0 400 200" preserveAspectRatio="none">
                    {/* Grid lines */}
                    <line x1="0" y1="0" x2="400" y2="0" stroke="#E5E7EB" strokeWidth="1" />
                    <line x1="0" y1="50" x2="400" y2="50" stroke="#E5E7EB" strokeWidth="1" />
                    <line x1="0" y1="100" x2="400" y2="100" stroke="#E5E7EB" strokeWidth="1" />
                    <line x1="0" y1="150" x2="400" y2="150" stroke="#E5E7EB" strokeWidth="1" />
                    <line x1="0" y1="200" x2="400" y2="200" stroke="#E5E7EB" strokeWidth="1" />

                    {/* Line path */}
                    <polyline
                      points={analyticsData.trends.map((point, index) => {
                        const x = (index / (analyticsData.trends.length - 1)) * 400;
                        const y = 200 - ((point.value - minValue) / range) * 180;
                        return `${x},${y}`;
                      }).join(' ')}
                      fill="none"
                      stroke="#3B82F6"
                      strokeWidth="3"
                      strokeLinecap="round"
                      strokeLinejoin="round"
                    />

                    {/* Data points */}
                    {analyticsData.trends.map((point, index) => {
                      const x = (index / (analyticsData.trends.length - 1)) * 400;
                      const y = 200 - ((point.value - minValue) / range) * 180;
                      return (
                        <circle
                          key={index}
                          cx={x}
                          cy={y}
                          r="4"
                          fill="#3B82F6"
                        />
                      );
                    })}
                  </svg>

                  {/* X-axis labels */}
                  <div className="flex justify-between mt-2">
                    {analyticsData.trends.map((point, index) => (
                      <span key={index} className="text-xs text-gray-600">
                        {point.month}
                      </span>
                    ))}
                  </div>
                </div>

                <p className="text-sm text-gray-600 mt-4">
                  You improved punctuality by <span className="font-bold">{analyticsData.improvement.percentage}%</span> {analyticsData.improvement.period}
                </p>
              </div>
            </div>

            {/* Bottom Section - Rewards */}
            <div className="bg-white rounded-xl shadow-md p-6">
              <h2 className="text-lg sm:text-xl font-black text-gray-900 mb-4">
                Rewards and Achievements
              </h2>

              <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                  <p className="text-sm text-gray-700 mb-2">
                    <span className="font-bold">Total Rewards Earned This Year:</span>{' '}
                    <span className="text-lg font-black text-gray-900">
                      {analyticsData.rewards.totalEarned} awards
                    </span>
                  </p>
                </div>

                <div className="text-sm text-gray-600 sm:text-right">
                  <p>
                    Maintain <span className="font-bold">100% attendance</span> this{' '}
                    <span className="font-bold">{analyticsData.rewards.targetMonth}</span> to earn a{' '}
                    <span className="font-bold">Perfect Attendance Badge!</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}