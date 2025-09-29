import React, { useState } from 'react';
import { 
  Home, 
  User, 
  Users, 
  Calendar, 
  Gift, 
  BarChart3, 
  LogOut 
} from 'lucide-react';

export default function Sidebar() {
  const [activeItem, setActiveItem] = useState('Applicant');

  const menuItems = [
    { id: 'Dashboard', label: 'Dashboard', icon: Home },    
    { id: 'Employee Profile', label: 'Employee Profile', icon: User },
    { id: 'Applicant', label: 'Applicant', icon: Users },
    { id: 'Schedule', label: 'Schedule', icon: Calendar },
    { id: 'Incentives', label: 'Incentives', icon: Gift },
    { id: 'Analytics', label: 'Analytics', icon: BarChart3 }
  ];

  return (
    <div className="w-64 h-screen bg-white shadow-lg flex flex-col">
      <div className="p-6 border-b border-gray-100">
        <div className="flex items-center gap-3">
          {/* Logo */}
          <img 
            src="src/assets/images/logo.png" 
            alt="Fur Ever Logo" 
            className="w-12 h-12 rounded-full object-cover"
          />
          
          <h1 className="text-xl font-bold text-gray-700 tracking-wide"
          style={{ color: "#5080BE" }}>
            FUR EVER
          </h1>
        </div>
      </div>

      <nav className="flex-1 py-6">
        <ul className="space-y-2 px-4">
          {menuItems.map((item) => {
            const Icon = item.icon;
            const isActive = activeItem === item.id;
            
            return (
              <li key={item.id}>
                <button
                  onClick={() => setActiveItem(item.id)}
                  className={`w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left transition-all duration-200 ${
                    isActive 
                      ? 'bg-blue-100 text-blue-600 shadow-sm' 
                      : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800'
                  }`}
                >
                  <Icon 
                    size={20} 
                    className={isActive ? 'text-blue-600' : 'text-gray-500'}
                  />
                  <span className="font-medium">{item.label}</span>
                </button>
              </li>
            );
          })}
        </ul>
      </nav>

      {/* Logout Button */}
      <div className="p-4 border-t border-gray-100">
        <button className="w-full flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-800 rounded-lg transition-all duration-200">
          <LogOut size={20} className="text-gray-500" />
          <span className="font-medium">LOGOUT</span>
        </button>
      </div>
    </div>
  );
}