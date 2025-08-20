<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Hệ thống quản lý</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
            color: #333;
            overflow-x: hidden;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            padding-top: 10px;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h2 {
            color: white;
            font-size: 18px;
            margin-top: 10px;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 20px 0 0 5px;
            width: 95%;
        }

        .nav-item {
            position: relative;
        }

        .dashboard-link {
            display: flex;
            align-items: center;
            color: #fff;
            font-size: 20px;
            padding: 16px 20px;
            border-radius: 8px;
            background: none;
            border: 2px solid rgba(255, 254, 254, 1);
            cursor: pointer;
            font-family: Inter, sans-serif;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
            position: relative;
        }

        .dashboard-link .arrow {
            margin-left: auto;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            display: inline-block;
            padding: 4px;
            transform: rotate(45deg);
            transition: transform 0.2s;
            cursor: pointer;
            position: relative;
            z-index: 10;
        }

        .dashboard-item.open .dashboard-link .arrow {
            transform: rotate(-135deg);
        }

        .dashboard-link:hover,
        .dashboard-link.active {
            background: #27ae60;
            color: #fff;
        }

        .dropdown-menu {
            display: none;
            list-style: none;
            padding: 0;
            margin: 0;
            background: #2ecc71;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 8px rgba(44,204,113,0.08);
            position: static;
            overflow: hidden;
        }

        .dashboard-item.open .dropdown-menu {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        /* Sub-menu styling */
        .sub-menu {
            display: none;
            list-style: none;
            padding-left: 20px;
            margin-top: 5px;
        }

        .nav-item:hover .sub-menu {
            display: block;
        }

        .sub-menu .nav-link {
            font-size: 14px;
            padding: 8px 15px;
            color: rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
            margin-bottom: 2px;
        }

        .sub-menu .nav-link:hover,
        .sub-menu .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .dropdown-menu .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                max-height: 0;
            }
            to {
                opacity: 1;
                max-height: 400px;
            }
        }

        .dropdown-menu .nav-item {
            border-bottom: 1px solid rgba(255, 255, 255, 1);
        }

        .dropdown-menu .nav-link {
            display: flex;
            align-items: center;
            color: #fff;
            font-size: 18px;
            padding: 12px 24px;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }

        .dropdown-menu .nav-link.active,
        .dropdown-menu .nav-link:hover {
            background: #27ae60;
            color: #fff;
        }

        .dropdown-menu .nav-link i {
            margin-right: 10px;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
            width: calc(100% - 250px);
            min-height: 100vh;
        }

        .top-header {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-title {
            font-size: 24px;
            color: #333;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: #333;
        }

        .user-role {
            font-size: 12px;
            color: #666;
        }

        .logout-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        /* Content Area */
        .main-content {
          
            padding: 30px;
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 80px);
           
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .content-header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
        }

        .content-header h1 i {
            margin-right: 10px;
            color: #2ecc71;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #2ecc71; color: white; }
        .btn-warning { background: #f39c12; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-edit { background: #17a2b8; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-secondary { background: #6c757d; color: white; }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        /* Content Box */
        .content-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .data-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        /* Search Form */
        .table-controls {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .search-form {
            display: flex;
            gap: 10px;
            max-width: 400px;
        }

        .search-form input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            overflow: auto; /* Cho phép scroll toàn bộ modal */
        }

        .modal-content {
            background: white;
            margin: 2% auto;
            padding: 0;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-height: 90vh; /* Giới hạn chiều cao */
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
        }

        .close {
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #999;
        }

        .close:hover {
            color: #333;
        }

        .modal-body {
            padding: 20px;
            overflow-y: auto; /* Cho phép scroll trong modal body */
            flex: 1; /* Chiếm không gian còn lại */
            max-height: calc(90vh - 140px); /* Trừ đi header và footer */
        }

        /* Custom scrollbar cho modal */
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Modal lớn cho product form */
        .modal-large .modal-content {
            max-width: 800px;
            width: 95%;
        }

        .form-help {
            display: block;
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        .required {
            color: #e74c3c;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #2ecc71;
            box-shadow: 0 0 0 2px rgba(46, 204, 113, 0.2);
        }

        .text-center {
            text-align: center;
        }

        /* Badges */
        .role-badge, .status-badge {
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 11px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 1px solid transparent;
            display: inline-block;
            min-width: 80px;
            text-align: center;
            white-space: nowrap;
        }

        /* Role Badges */
        .role-badge {
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-admin { 
            background: linear-gradient(135deg, #fecaca 0%, #fee2e2 100%); 
            color: #991b1b; 
            border-color: #fca5a5;
        }

        .role-user { 
            background: linear-gradient(135deg, #93c5fd 0%, #dbeafe 100%); 
            color: #1e40af; 
            border-color: #60a5fa;
        }

        /* Status Badges */
        .status-hoạt-động { 
            background: linear-gradient(135deg, #86efac 0%, #d1fae5 100%); 
            color: #065f46; 
            border-color: #4ade80;
        }

        .status-bị-khóa { 
            background: linear-gradient(135deg, #fca5a5 0%, #fed7d7 100%); 
            color: #9b2c2c; 
            border-color: #f87171;
        }

        .status-còn-hàng { 
            background: linear-gradient(135deg, #86efac 0%, #d1fae5 100%); 
            color: #065f46; 
            border-color: #4ade80;
        }

        .status-hết-hàng { 
            background: linear-gradient(135deg, #fca5a5 0%, #fed7d7 100%); 
            color: #9b2c2c; 
            border-color: #f87171;
        }

        .status-ngừng-bán { 
            background: linear-gradient(135deg, #fde68a 0%, #fef3c7 100%); 
            color: #92400e; 
            border-color: #fbbf24;
        }

        /* Order status badges - Updated */
        .status-chờ-xác-nhận { 
            background: linear-gradient(135deg, #fde68a 0%, #fef3c7 100%) !important; 
            color: #92400e !important; 
            border: 1px solid #fbbf24 !important;
            font-weight: 600 !important;
        }

        .status-đã-xác-nhận { 
            background: linear-gradient(135deg, #93c5fd 0%, #dbeafe 100%) !important; 
            color: #1e40af !important; 
            border: 1px solid #60a5fa !important;
            font-weight: 600 !important;
        }

        .status-đang-giao { 
            background: linear-gradient(135deg, #c084fc 0%, #e9d5ff 100%) !important; 
            color: #7c3aed !important; 
            border: 1px solid #a78bfa !important;
            font-weight: 600 !important;
        }

        .status-đã-giao { 
            background: linear-gradient(135deg, #86efac 0%, #d1fae5 100%) !important; 
            color: #065f46 !important; 
            border: 1px solid #4ade80 !important;
            font-weight: 600 !important;
        }

        .status-đã-hủy { 
            background: linear-gradient(135deg, #fca5a5 0%, #fed7d7 100%) !important; 
            color: #9b2c2c !important; 
            border: 1px solid #f87171 !important;
            font-weight: 600 !important;
        }

        /* Hover effects for status badges */
        .status-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.2s ease;
        }

        /* Test class to verify CSS is loading */
        .status-badge {
            padding: 8px 12px !important;
            border-radius: 16px !important;
            font-size: 12px !important;
            display: inline-block !important;
            min-width: 90px !important;
            text-align: center !important;
            white-space: nowrap !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
                transition: transform 0.3s;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-wrapper {
                margin-left: 0;
            }
            
            .content-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .main-content {
              
                max-height: calc(100vh - 60px);
               
              
            }
            
            /* Modal responsive */
            .modal-content {
                margin: 1% auto;
                width: 95%;
                max-height: 95vh;
            }
            
            .modal-body {
                max-height: calc(95vh - 120px);
                padding: 15px;
            }

            .nav-menu {
        font-size: 15px;
        padding: 12px 10px;
    }
        }
        .fa-solid, .fas {
            font-weight: 900;
            margin: 0 8px;
        }

        /* === INVENTORY DASHBOARD CSS === */
        
        /* Statistics Cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .stat-total { border-left-color: #3498db; }
        .stat-success { border-left-color: #2ecc71; }
        .stat-warning { border-left-color: #f39c12; }
        .stat-danger { border-left-color: #e74c3c; }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 24px;
            color: white;
        }

        .stat-total .stat-icon { background: #3498db; }
        .stat-success .stat-icon { background: #2ecc71; }
        .stat-warning .stat-icon { background: #f39c12; }
        .stat-danger .stat-icon { background: #e74c3c; }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Inventory Content */
        .inventory-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .inventory-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .section-header {
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-count {
            background: #2ecc71;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Low Stock Alert */
        .low-stock-list {
            padding: 15px 0;
        }

        .low-stock-item {
            padding: 10px 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .low-stock-item:last-child {
            border-bottom: none;
        }

        .stock-number {
            background: #f39c12;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Stock Badges */
        .stock-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
            min-width: 50px;
        }

        .stock-low { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .stock-out { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .stock-good { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 5px;
        }

        /* Inventory Tables */
        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inventory-table th,
        .inventory-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .inventory-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .inventory-table tr:hover {
            background: #f8f9fa;
        }

        /* Empty States */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 15px;
        }

        /* Quick Stock Modal Enhancements */
        .stock-input-group {
            display: flex;
            gap: 10px;
            align-items: end;
        }

        .stock-input-group .form-group {
            flex: 1;
        }

        .stock-preview {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            border-left: 4px solid #2ecc71;
        }

        .content-header .action-buttons {
            display: flex;
            gap: 12px; /* Khoảng cách vừa phải giữa các nút */
            align-items: center;
        }

        /* Responsive Design for Inventory */
        @media (max-width: 768px) {
            .stats-row {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }

            .inventory-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
                margin-right: 15px;
            }

            .stat-number {
                font-size: 24px;
            }

            .content-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .action-buttons {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }

            .action-buttons .btn {
                flex: 1;
                min-width: 120px;
            }
        }
        .pagination-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
        }

        .pagination .page-link {
            display: inline-block;
            padding: 8px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            color: #007bff;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.25s ease-in-out;
        }

        .pagination .page-link:hover {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        .pagination .page-link.active {
            background: #007bff;
            color: #fff;
            font-weight: bold;
            cursor: default;
        }

        .pagination .page-ellipsis {
            padding: 8px 12px;
            color: #777;
            font-size: 14px;
        }

        /* Nút Prev / Next */
        .pagination .prev,
        .pagination .next {
            font-weight: bold;
        }

        /* Jump form */
        .page-jump {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .page-jump label {
            font-weight: 500;
            color: #333;
        }

        .page-jump .page-input {
            width: 70px;
            padding: 5px 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            text-align: center;
        }

        .page-jump .btn {
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 14px;
        }
        .pagination .page-btn {
    padding: 8px 12px;
    border-radius: 6px;
    background: #fff;
    color: #000;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease-in-out;
    border: 1px solid #1e1e1e;
    cursor: pointer;
}

/* Hover */
.pagination .page-btn:hover {
    background: #333;
    color: #fff;
}
/* Khi nhấn giữ chuột */
.pagination .page-btn:active {
    background: #3e9b00ff;  /* xanh nổi bật */
    color: #fff;
    border-color: #3e9b00ff;
    transform: scale(0.95); /* hiệu ứng nhấn xuống */
}

    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-cogs fa-2x" style="color: white;"></i>
                <h2>Admin Panel</h2>
                <div style="padding: 10px 0; border-top: 1px solid rgba(255,255,255,0.2); margin-top: 10px;">
                    <div style="color: rgba(255,255,255,0.8); font-size: 12px;">Xin chào,</div>
                    <div style="color: white; font-weight: 600; font-size: 14px;">
                        <?php echo htmlspecialchars($_SESSION['user']['fullname'] ?? $_SESSION['user']['username'] ?? 'Admin'); ?>
                    </div>
                    <a href="logout.php" style="color: rgba(255,255,255,0.7); font-size: 12px; text-decoration: none; margin-top: 5px; display: inline-block;">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </div>
            </div>
            <ul class="nav-menu">
    <li class="nav-item dashboard-item">
        <a href="index.php?page=dashboard" class="nav-link dashboard-link <?= in_array(($_GET['page'] ?? 'dashboard'), ['dashboard', 'user_list', 'Category', 'product', 'order_list', 'inventory', 'comment_list', 'voucher_list']) ? ' active' : '' ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard <span class="arrow"></span>
        </a>
        <ul class="dropdown-menu">
            <li class="nav-item">
                <a href="index.php?page=user_list" class="nav-link<?= ($_GET['page'] ?? '') == 'user_list' ? ' active' : '' ?>">
                    <i class="fas fa-users"></i> Quản lý Người dùng
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=Category" class="nav-link<?= ($_GET['page'] ?? '') == 'Category' ? ' active' : '' ?>">
                    <i class="fas fa-tags"></i> Quản lý Danh mục
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=product" class="nav-link<?= ($_GET['page'] ?? '') == 'product' ? ' active' : '' ?>">
                    <i class="fas fa-box"></i> Quản lý Sản phẩm
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=order_list" class="nav-link<?= ($_GET['page'] ?? '') == 'order_list' ? ' active' : '' ?>">
                    <i class="fas fa-shopping-cart"></i> Quản lý Đơn hàng
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=inventory" class="nav-link<?= ($_GET['page'] ?? '') == 'inventory' ? ' active' : '' ?>">
                    <i class="fas fa-warehouse"></i> Quản lý Tồn kho
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=comment_list" class="nav-link<?= ($_GET['page'] ?? '') == 'comment_list' ? ' active' : '' ?>">
                    <i class="fas fa-comments"></i> Quản lý Bình luận
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=voucher_list" class="nav-link<?= ($_GET['page'] ?? '') == 'voucher_list' ? ' active' : '' ?>">
                    <i class="fas fa-tags"></i> Quản lý Voucher
                </a>
            </li>
        </ul>
    </li>
</ul>

        </div>

        <!-- Main Content Wrapper -->
        <div class="main-wrapper">
            <!-- Top Header -->
            <div class="top-header">
                <div class="header-title">
                    Hệ thống quản lý
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <?= substr($_SESSION['user']['HoTen'] ?? 'A', 0, 1) ?>
                    </div>
                    <div class="user-details">
                        <span class="user-name"><?= $_SESSION['user']['HoTen'] ?? 'Admin' ?></span>
                        <span class="user-role">Quản trị viên</span>
                    </div>
                    <button class="logout-btn" onclick="window.location.href='logout.php'">
                        <i class="fas fa-sign-out-alt"></i>
                        Đăng xuất
                    </button>
                </div>
            </div>

<script>
// Modal functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'block';
    
    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
    
    // Focus vào modal để có thể scroll
    setTimeout(() => {
        const modalBody = modal.querySelector('.modal-body');
        if (modalBody) {
            modalBody.scrollTop = 0; // Reset scroll position
        }
    }, 100);
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (modal.style.display === 'block') {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var dashboardItem = document.querySelector('.dashboard-item');
    var dashboardLink = document.querySelector('.dashboard-link');
    var dropdownMenu = document.querySelector('.dropdown-menu');
    
    // Xử lý click vào main dashboard link
    dashboardLink.addEventListener('click', function(e) {
        e.preventDefault(); // Luôn prevent để chỉ toggle dropdown
        e.stopPropagation();
        dashboardItem.classList.toggle('open');
    });
    
    // Ngăn dropdown đóng khi click vào dropdown menu area
    if (dropdownMenu) {
        dropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation(); // Ngăn event bubble lên parent
        });
    }
    
    // Đóng dropdown khi click ra ngoài
    document.addEventListener('click', function(e) {
        if (!dashboardItem.contains(e.target)) {
            dashboardItem.classList.remove('open');
        }
    });
    
    // Tự động mở dropdown nếu đang ở trang con
    var currentPage = '<?= $_GET['page'] ?? 'dashboard' ?>';
    if (["user_list","Category","product","order_list","inventory","comment_list","voucher_list"].includes(currentPage)) {
        dashboardItem.classList.add('open');
    }
    
    // Xử lý hover để cải thiện UX
    dashboardItem.addEventListener('mouseenter', function() {
        // Có thể thêm hover effect nếu cần
    });
    
    dashboardItem.addEventListener('mouseleave', function() {
        // Có thể thêm hover effect nếu cần
    });
});
</script>
