@extends('layouts.main')

@section('page-title', 'Detail Transaksi')

@section('content')

<style>
    .detail-card {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        max-width: 900px;
        margin: 0 auto;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .detail-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .detail-header-left i {
        font-size: 32px;
        color: #2563eb;
    }

    .detail-header-left h2 {
        margin: 0;
        font-size: 24px;
        color: #1e3a8a;
        font-weight: 700;
    }

    .id-badge {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fbbf24;
    }

    .status-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    .status-failed {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }

    .detail-section {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #1e3a8a;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        font-size: 20px;
        color: #2563eb;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .detail-item {
        background: #f8fafc;
        padding: 18px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .detail-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .detail-value {
        font-size: 16px;
        font-weight: 600;
        color: #1e3a8a;
    }

    .detail-value.highlight {
        font-size: 24px;
        color: #2563eb;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: linear-gradient(135deg, rgba(30, 58, 138, 0.05), rgba(37, 99,