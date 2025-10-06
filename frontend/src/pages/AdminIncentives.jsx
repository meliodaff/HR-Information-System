import React, { useState } from 'react';
import { MoreVertical } from 'lucide-react';
import DashboardLayout from '../components/layouts/DashboardLayout';

export default function AdminIncentives() {
  const [activeTab, setActiveTab] = useState('request');
  const [activeMenu, setActiveMenu] = useState(null);

  const [claimRequests, setClaimRequests] = useState([
    { name: 'Sphere Star', reward: 'Employee of the Month', dateAwarded: '09/09/2025', awardBonus: 'GiftCard', status: 'Pending' },
    { name: 'Sphere Star', reward: 'Employee of the Month', dateAwarded: '', awardBonus: '', status: 'Pending' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', status: '' }
  ]);

  const claimHistory = [
    { name: 'Sphere Star', reward: 'Employee of the Month', dateAwarded: '09/09/2025', awardBonus: 'GiftCard', dateClaimed: '09/20/2025', status: 'Claimed' },
    { name: 'Sphere Star', reward: 'Employee of the Month', dateAwarded: '09/09/2025', awardBonus: 'GiftCard', dateClaimed: '09/20/2025', status: 'Claimed' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', dateClaimed: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', dateClaimed: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', dateClaimed: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', dateClaimed: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', dateClaimed: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', dateClaimed: '', status: '' },
    { name: 'Sphere Star', reward: '', dateAwarded: '', awardBonus: '', dateClaimed: '', status: '' }
  ];

  const leaderboard = [
    { date: '1', name: 'NAME', reward: 'REWARD EARNED' },
    { date: '2', name: 'NAME', reward: 'REWARD EARNED' },
    { date: '3', name: 'NAME', reward: 'REWARD EARNED' },
    { date: '4', name: 'NAME', reward: 'REWARD EARNED' },
    { date: '5', name: 'NAME', reward: 'REWARD EARNED' }
  ];

  const menuOptions = ['Pending Approval', 'Approved', 'Rejected'];

  const toggleMenu = (index) => {
    setActiveMenu(activeMenu === index ? null : index);
  };

  const handleStatusChange = (status, index) => {
    const updatedRequests = [...claimRequests];
    updatedRequests[index].status = status;
    setClaimRequests(updatedRequests);
    setActiveMenu(null);
    console.log(`Status changed to: ${status} for ${updatedRequests[index].name}`);
  };

  //status badge color
  const getStatusColor = (status) => {
    switch (status) {
      case 'Pending':
      case 'Pending Approval':
        return 'bg-yellow-100 text-yellow-800';
      case 'Approved':
        return 'bg-green-100 text-green-800';
      case 'Rejected':
        return 'bg-red-100 text-red-800';
      case 'Claimed':
        return 'bg-blue-100 text-blue-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  return (
    <DashboardLayout>
    <div className="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
      <div className="max-w-7xl mx-auto">
        <h1 className="text-3xl sm:text-4xl font-black text-gray-900 mb-6">INCENTIVES</h1>

        {/* Stats and Leaderboard */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
          <div className="space-y-6">
            {/* Stats Cards */}
            <div className="grid grid-cols-2 gap-4">
              <div className="bg-white rounded-xl shadow-md p-6 text-center">
                <div className="text-4xl sm:text-5xl font-black text-gray-900 mb-2">100</div>
                <div className="text-sm text-gray-600">Overall Attendance</div>
              </div>
              <div className="bg-white rounded-xl shadow-md p-6 text-center">
                <div className="text-4xl sm:text-5xl font-black text-gray-900 mb-2">20</div>
                <div className="text-sm text-gray-600">Pending Request</div>
              </div>
            </div>

            {/* Employee of the Month */}
            <div className="bg-white rounded-xl shadow-md p-6">
              <div className="flex items-center gap-4">
                <div className="w-16 h-16 sm:w-20 sm:h-20 bg-blue-100 rounded-xl overflow-hidden flex-shrink-0">
                  <img 
                    src="src/assets/images/profile.jpg" 
                    alt="Employee of the Month"
                    className="w-full h-full object-cover"
                  />
                </div>
                <div>
                  <h3 className="text-sm sm:text-base font-bold text-gray-900 mb-1">
                    Employee Of the Month - August 2025
                  </h3>
                  <p className="text-xs sm:text-sm text-gray-600">
                    outstanding pet care & teamwork
                  </p>
                </div>
              </div>
            </div>
          </div>

          {/* Right - Leaderboard */}
          <div className="bg-white rounded-xl shadow-md p-6">
            <h2 className="text-lg sm:text-xl font-black text-gray-900 mb-4">
              Leaderboard / Top Performer
            </h2>
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead className="border-b-2 border-gray-200">
                  <tr>
                    <th className="px-2 sm:px-4 py-2 text-left font-black text-gray-900 uppercase">Date</th>
                    <th className="px-2 sm:px-4 py-2 text-left font-black text-gray-900 uppercase">Name</th>
                    <th className="px-2 sm:px-4 py-2 text-left font-black text-gray-900 uppercase">Reward Earned</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-100">
                  {leaderboard.map((item, index) => (
                    <tr key={index} className="hover:bg-gray-50">
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{item.date}</td>
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{item.name}</td>
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{item.reward}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {/* Tab Buttons */}
        <div className="flex gap-4 mb-6">
          <button
            onClick={() => setActiveTab('request')}
            className={`flex-1 px-6 py-3 rounded-lg font-bold text-sm transition-all ${
              activeTab === 'request'
                ? 'bg-blue-400 text-white shadow-md'
                : 'bg-gray-200 text-gray-600 hover:bg-gray-300'
            }`}
          >
            REWARD CLAIM REQUEST
          </button>
          <button
            onClick={() => setActiveTab('history')}
            className={`flex-1 px-6 py-3 rounded-lg font-bold text-sm transition-all ${
              activeTab === 'history'
                ? 'bg-blue-400 text-white shadow-md'
                : 'bg-gray-200 text-gray-600 hover:bg-gray-300'
            }`}
          >
            REWARD CLAIM HISTORY
          </button>
        </div>

        {/* Reward Claim Request Table */}
        {activeTab === 'request' && (
          <div className="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-lg overflow-hidden">
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead className="bg-white border-b-2 border-blue-200">
                  <tr>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Employee Name</th>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Reward Awarded</th>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Date Awarded</th>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Award/Bonus</th>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Status</th>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Action</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-blue-100">
                  {claimRequests.map((claim, index) => (
                    <tr key={index} className="hover:bg-white/50 transition-colors">
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{claim.name}</td>
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{claim.reward}</td>
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{claim.dateAwarded}</td>
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{claim.awardBonus}</td>
                      <td className="px-2 sm:px-4 py-3">
                        {claim.status && (
                          <span className={`inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${getStatusColor(claim.status)}`}>
                            {claim.status}
                          </span>
                        )}
                      </td>
                      <td className="px-2 sm:px-4 py-3">
                        <div className="relative">
                          <button
                            onClick={() => toggleMenu(index)}
                            className="p-1 hover:bg-gray-100 rounded-full transition-colors"
                          >
                            <MoreVertical className="w-5 h-5 text-gray-600" />
                          </button>

                          {activeMenu === index && (
                            <div className="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                              {menuOptions.map((option, optIndex) => (
                                <button
                                  key={optIndex}
                                  onClick={() => handleStatusChange(option, index)}
                                  className="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors"
                                >
                                  {option}
                                </button>
                              ))}
                            </div>
                          )}
                        </div>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        )}

        {/* Reward Claim History Table */}
        {activeTab === 'history' && (
          <div className="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-lg overflow-hidden">
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead className="bg-white border-b-2 border-blue-200">
                  <tr>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Employee Name</th>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Reward Awarded</th>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Date Awarded</th>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Award/Bonus</th>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Date Claimed</th>
                    <th className="px-2 sm:px-4 py-3 text-left font-black text-gray-900 uppercase whitespace-nowrap">Status</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-blue-100">
                  {claimHistory.map((claim, index) => (
                    <tr key={index} className="hover:bg-white/50 transition-colors">
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{claim.name}</td>
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{claim.reward}</td>
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{claim.dateAwarded}</td>
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{claim.awardBonus}</td>
                      <td className="px-2 sm:px-4 py-3 text-gray-900">{claim.dateClaimed}</td>
                      <td className="px-2 sm:px-4 py-3">
                        {claim.status && (
                          <span className={`inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${getStatusColor(claim.status)}`}>
                            {claim.status}
                          </span>
                        )}
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        )}
      </div>
    </div>
    </DashboardLayout>
  );
}