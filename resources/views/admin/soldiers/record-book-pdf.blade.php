<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'HindSiliguri';
            src: url('{{ storage_path("fonts/HindSiliguri-Regular.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'HindSiliguri';
            src: url('{{ storage_path("fonts/HindSiliguri-Bold.ttf") }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        @page {
            margin: 0.5in;
        }
        body {
            font-family: 'HindSiliguri', sans-serif;
            line-height: 1.6;
            color: #333;
            font-size: 11px;
        }
        .header, .footer {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            color: #666;
            margin-bottom: 20px;
        }
        .restricted {
            border: 1px solid #ddd;
            padding: 2px 10px;
            display: inline-block;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 30px;
            text-decoration: underline;
        }
        .photo-box {
            float: right;
            width: 100px;
            height: 120px;
            border: 1px solid #333;
            text-align: center;
            line-height: 120px;
            font-size: 10px;
            color: #999;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th {
            text-align: left;
            width: 200px;
            padding: 5px;
            border-bottom: 1px dotted #ccc;
        }
        .info-table td {
            padding: 5px;
            border-bottom: 1px dotted #ccc;
        }
        .section-title {
            background: #f4f4f4;
            padding: 5px 10px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            border-left: 4px solid #333;
        }
        .trg-table {
            width: 100%;
            border-collapse: collapse;
        }
        .trg-table th, .trg-table td {
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
        }
        .trg-table th {
            background: #eee;
        }
    </style>
</head>
<body>
    <div class="header">
        <span class="restricted">ব্যক্তিগত (RESTRICTED)</span>
    </div>

    <div class="photo-box">
        সৈনিকের ছবি
    </div>

    <div class="title">ব্যক্তিগত তথ্যাবলী (PERSONAL INFORMATION)</div>

    <table class="info-table">
        <tr>
            <th>ব্যক্তিগত নং (Personal No):</th>
            <td>{{ $soldier->personal_no }}</td>
        </tr>
        <tr>
            <th>পদবী (Rank):</th>
            <td>{{ $soldier->rank }} ({{ $soldier->rank_bn ?? 'সৈনিক' }})</td>
        </tr>
        <tr>
            <th>নাম (Name):</th>
            <td>{{ $soldier->name }} ({{ $soldier->name_bn ?? 'নাম নেই' }})</td>
        </tr>
        <tr>
            <th>নিযুক্তি (Appointment):</th>
            <td>{{ $soldier->appointment }} ({{ $soldier->appointment_bn ?? 'নিযুক্তি' }})</td>
        </tr>
        <tr>
            <th>ইউনিট/সাব ইউনিট (Unit/Sub Unit):</th>
            <td>{{ $soldier->unit }} / {{ $soldier->sub_unit }}</td>
        </tr>
        <tr>
            <th>ভর্তির তারিখ (Date of Enrolment):</th>
            <td>{{ $soldier->enrolment_date ? $soldier->enrolment_date->format('d M Y') : '' }}</td>
        </tr>
        <tr>
            <th>পদবী প্রাপ্তি (Date of Rank):</th>
            <td>{{ $soldier->rank_date ? $soldier->rank_date->format('d M Y') : '' }}</td>
        </tr>
        <tr>
            <th>শিক্ষাগত যোগ্যতা (Civil Education):</th>
            <td>{{ $soldier->education }}</td>
        </tr>
        <tr>
            <th>রক্তের গ্রুপ (Blood Group):</th>
            <td>{{ $soldier->blood_group }}</td>
        </tr>
        <tr>
            <th>ওজন (Weight):</th>
            <td>{{ $soldier->weight }}</td>
        </tr>
        <tr>
            <th>স্থায়ী ঠিকানা (Permanent Address):</th>
            <td>{{ $soldier->permanent_address }}</td>
        </tr>
    </table>

    <div class="section-title">পারিবারিক তথ্য (FAMILY INFORMATION)</div>
    <table class="info-table">
        <tr>
            <th>পিতার নাম:</th>
            <td>{{ $soldier->father_name }}</td>
        </tr>
        <tr>
            <th>মাতার নাম:</th>
            <td>{{ $soldier->mother_name }}</td>
        </tr>
        <tr>
            <th>স্ত্রীর নাম:</th>
            <td>{{ $soldier->spouse_name ?: 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">প্রশিক্ষণ তথ্য (TRAINING RECORDS)</div>
    <table class="trg-table">
        <thead>
            <tr>
                <th rowspan="2">আইপিএফটি (IPFT)</th>
                <th colspan="2">বাৎসরিক বাঞ্চাল</th>
            </tr>
            <tr>
                <th>বাঞ্চাল-১ (Biannual-1)</th>
                <th>বাঞ্চাল-২ (Biannual-2)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ফলাফল (Status)</td>
                <td>{{ $soldier->ipft_1_status ?: 'Pass' }}</td>
                <td>{{ $soldier->ipft_2_status ?: 'Pass' }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <table class="trg-table">
            <thead>
                <tr>
                    <th>নি ফায়ারিং (Ni Firing)</th>
                    <th>গ্রেনেড ফায়ারিং (Grenade)</th>
                    <th>স্পিড মার্চ (Speed March)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $soldier->ni_firing_status ?: '2/4' }}</td>
                    <td>{{ $soldier->grenade_firing_status ?: '2/4' }}</td>
                    <td>{{ $soldier->speed_march_status ?: '2/4' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer" style="position: fixed; bottom: 0; width: 100%;">
        <span class="restricted">ব্যক্তিগত (RESTRICTED)</span>
    </div>
</body>
</html>
