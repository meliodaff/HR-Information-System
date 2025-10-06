import { Users, TrendingUp, } from 'lucide-react';
import { LineChart, Line, BarChart, Bar, PieChart, Pie, Cell, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from 'recharts';
import DashboardLayout from '../components/layouts/DashboardLayout';
export default function AdminAnalytics() {
  // Sample data
  const statsData = {
    overallAttendance: 90.64,
    avgPerformance: 9.3,
    totalIncentives: 67750
  };

  const attendanceTrends = [
    { month: 'Jan', value: 85 },
    { month: 'Feb', value: 87 },
    { month: 'Mar', value: 88 },
    { month: 'Apr', value: 89 },
    { month: 'May', value: 90 },
    { month: 'Jun', value: 90.5 },
    { month: 'Jul', value: 90.64 }
  ];

  const performanceData = [
    { month: 'Jan', value: 60 },
    { month: 'Feb', value: 68 },
    { month: 'Mar', value: 65 },
    { month: 'Apr', value: 78 },
    { month: 'May', value: 82 },
    { month: 'Jun', value: 88 }
  ];

  const attendanceBreakdown = [
    { name: 'Present', value: 90.64, color: '#60a5fa' },
    { name: 'Absent', value: 5, color: '#f87171' },
    { name: 'Late', value: 4.36, color: '#fb923c' }
  ];

  const schedulingData = {
    mostCommonHours: 30,
    month: 'Aug'
  };

  return (
    <DashboardLayout>
    <div className="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
      <div className="max-w-7xl mx-auto">
        <h1 className="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 sm:mb-8">ANALYTICS</h1>
        
        {/* Top Stats */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
          <div className="bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl p-6 text-white shadow-lg">
            <div className="text-4xl sm:text-5xl font-bold mb-1">{statsData.overallAttendance}%</div>
            <div className="text-blue-100 text-sm">Overall Attendance</div>
          </div>
          
          <div className="bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl p-6 text-white shadow-lg">
            <div className="text-4xl sm:text-5xl font-bold mb-1">{statsData.avgPerformance}</div>
            <div className="text-blue-100 text-sm">Average Performance</div>
          </div>
          
          <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-200 sm:col-span-2 lg:col-span-1">
            <div className="flex items-center gap-3 mb-1">
              <span className="text-gray-400 text-2xl font-semibold">₱</span>
              <div className="text-3xl sm:text-4xl font-bold text-gray-900">{statsData.totalIncentives.toLocaleString()}</div>
            </div>
            <div className="text-gray-500 text-sm">Total Incentives Given</div>
          </div>
        </div>

        {/* Charts Grid */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
          {/* Overall Attendance Pie Chart */}
          <div className="bg-white rounded-xl p-4 sm:p-6 shadow-lg border border-gray-200">
            <h2 className="text-base sm:text-lg font-bold text-gray-900 mb-4 sm:mb-6">Overall Attendance</h2>
            <div className="relative">
              <ResponsiveContainer width="100%" height={240}>
                <PieChart>
                  <Pie
                    data={attendanceBreakdown}
                    cx="50%"
                    cy="50%"
                    innerRadius={50}
                    outerRadius={80}
                    dataKey="value"
                  >
                    {attendanceBreakdown.map((entry, index) => (
                      <Cell key={`cell-${index}`} fill={entry.color} />
                    ))}
                  </Pie>
                  <Tooltip formatter={(value) => `${value}%`} />
                </PieChart>
              </ResponsiveContainer>
              <div className="flex flex-wrap gap-3 justify-center mt-4">
                {attendanceBreakdown.map((item) => (
                  <div key={item.name} className="flex items-center gap-2">
                    <div className="w-3 h-3 rounded-full" style={{ backgroundColor: item.color }}></div>
                    <span className="text-xs sm:text-sm text-gray-700">{item.name}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>

          {/* Employee Performance Bar Chart */}
          <div className="bg-white rounded-xl p-4 sm:p-6 shadow-lg border border-gray-200">
            <h2 className="text-base sm:text-lg font-bold text-gray-900 mb-4 sm:mb-6">Employee Performance Comparison</h2>
            <ResponsiveContainer width="100%" height={240}>
              <BarChart data={performanceData}>
                <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
                <XAxis dataKey="month" tick={{ fontSize: 11 }} />
                <YAxis tick={{ fontSize: 11 }} />
                <Tooltip />
                <Bar dataKey="value" fill="#60a5fa" radius={[6, 6, 0, 0]} />
              </BarChart>
            </ResponsiveContainer>
          </div>

          {/* Attendance Trends Line Chart */}
          <div className="bg-white rounded-xl p-4 sm:p-6 shadow-lg border border-gray-200">
            <h2 className="text-base sm:text-lg font-bold text-gray-900 mb-4 sm:mb-6">Attendance Trends</h2>
            <ResponsiveContainer width="100%" height={240}>
              <LineChart data={attendanceTrends}>
                <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
                <XAxis dataKey="month" tick={{ fontSize: 11 }} />
                <YAxis tick={{ fontSize: 11 }} domain={[0, 100]} />
                <Tooltip formatter={(value) => `${value}%`} />
                <Line 
                  type="monotone" 
                  dataKey="value" 
                  stroke="#60a5fa" 
                  strokeWidth={2} 
                  dot={{ fill: '#60a5fa', r: 4 }} 
                />
              </LineChart>
            </ResponsiveContainer>
          </div>

          {/* Scheduling Analysis */}
          <div className="bg-white rounded-xl p-4 sm:p-6 shadow-lg border border-gray-200">
            <h2 className="text-base sm:text-lg font-bold text-gray-900 mb-4 sm:mb-6">Scheduling Analysis</h2>
            <div className="flex items-center justify-center h-60">
              <div className="text-center">
                <p className="text-gray-700 text-sm sm:text-base">
                  Most employee worked <span className="font-bold text-2xl sm:text-3xl text-blue-500 block my-2">{schedulingData.mostCommonHours} hours</span> per week in {schedulingData.month}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </DashboardLayout>
  );
}