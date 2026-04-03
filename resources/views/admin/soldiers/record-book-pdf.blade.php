<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'HindSiliguri';
            @php
                $fontPath = storage_path('fonts/HindSiliguri-Regular.ttf');
                $fontData = base64_encode(file_get_contents($fontPath));
            @endphp
            src: url('data:font/truetype;charset=utf-8;base64,{{ $fontData }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'HindSiliguri';
            @php
                $fontBoldPath = storage_path('fonts/HindSiliguri-Bold.ttf');
                $fontBoldData = base64_encode(file_get_contents($fontBoldPath));
            @endphp
            src: url('data:font/truetype;charset=utf-8;base64,{{ $fontBoldData }}') format('truetype');
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
            width: 110px;
            height: 135px;
            border: 1px solid #333;
            text-align: center;
            font-size: 10px;
            color: #999;
            overflow: hidden;
        }
        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            clear: both;
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
        @if($soldier->photo && file_exists(public_path('storage/' . $soldier->photo)))
            @php
                $imageData = base64_encode(file_get_contents(public_path('storage/' . $soldier->photo)));
                $mimeType = mime_content_type(public_path('storage/' . $soldier->photo));
            @endphp
            <img src="data:{{ $mimeType }};base64,{{ $imageData }}">
        @else
            <div style="line-height: 135px;">সৈনিকের ছবি</div>
        @endif
    </div>

    <div class="title">ব্যক্তিগত তথ্যাবলী (PERSONAL INFORMATION)</div>

    <table class="info-table">
        <tr>
            <th>সৈনিকের নাম (Name):</th>
            <td>{{ $soldier->name }} ({{ $soldier->name_bn ?? 'নাম নেই' }})</td>
        </tr>
        <tr>
            <th>সেনা নং (Service No):</th>
            <td>{{ $soldier->number }}</td>
        </tr>
        <tr>
            <th>পদবী (Rank):</th>
            <td>{{ $soldier->rank }} ({{ $soldier->rank_bn ?? 'সৈনিক' }})</td>
        </tr>
        <tr>
            <th>নিযুক্তি (Appointment):</th>
            <td>{{ $soldier->appointment }} ({{ $soldier->appointment_bn ?? 'নিযুক্তি' }})</td>
        </tr>
        <tr>
            <th>ইউনিট (Unit Hierarchy):</th>
            <td>
                @if($soldier->unit)
                    @php
                        $path = [];
                        $curr = $soldier->unit;
                        while($curr) {
                            $path[] = $curr->name;
                            $curr = $curr->parent;
                        }
                        echo implode(' > ', array_reverse($path));
                    @endphp
                @else
                    N/A
                @endif
            </td>
        </tr>
        <tr>
            <th>ভর্তির তারিখ (Date of Enrolment):</th>
            <td>{{ $soldier->enrolment_date ? \Carbon\Carbon::parse($soldier->enrolment_date)->format('d M Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>পদবী প্রাপ্তি (Date of Rank):</th>
            <td>{{ $soldier->rank_date ? \Carbon\Carbon::parse($soldier->rank_date)->format('d M Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>শিক্ষাগত যোগ্যতা (Civil Education):</th>
            <td>{{ $soldier->civil_education ?? 'N/A' }}</td>
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

    <div class="section-title">ব্যক্তিগত তথ্য (PERSONAL DETAILS ১২-১৯)</div>
    <table class="info-table">
        <tr>
            <th>পিতার নাম (Father's Name):</th>
            <td>{{ $soldier->father_name }}</td>
        </tr>
        <tr>
            <th>মাতার নাম (Mother's Name):</th>
            <td>{{ $soldier->mother_name }}</td>
        </tr>
        <tr>
            <th>স্ত্রীর নাম (Spouse Name):</th>
            <td>{{ $soldier->spouse_name ?: 'N/A' }}</td>
        </tr>
        <tr>
            <th>ধর্ম (Religion):</th>
            <td>{{ $soldier->religion ?: 'N/A' }}</td>
        </tr>
        <tr>
            <th>বৈবাহিক অবস্থা (Marital Status):</th>
            <td>{{ $soldier->marital_status ?: 'N/A' }}</td>
        </tr>
        <tr>
            <th>জন্ম তারিখ (Date of Birth):</th>
            <td>{{ $soldier->dob ? \Carbon\Carbon::parse($soldier->dob)->format('d M Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>জাতীয় পরিচয়পত্র (NID):</th>
            <td style="font-family: monospace; font-weight: bold;">{{ $soldier->nid ?: 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">পদোন্নতিবিষয়ক প্রশিক্ষণ ও কোর্স/ক্যাডার (PROMOTION TRAINING)</div>
    <table class="trg-table">
        <thead>
            <tr style="background: #333; color: white;">
                <th>ক্র: (Sl)</th>
                <th>প্রশিক্ষণ ও কোর্স/ক্যাডার (Course)</th>
                <th>সুযোগ (Chance)</th>
                <th>সাল (Year)</th>
                <th>ফলাফল ও প্রাধিকার (Details)</th>
            </tr>
        </thead>
        <tbody>
            @if($soldier->courses && count($soldier->courses) > 0)
                @foreach($soldier->courses as $index => $course)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td style="font-weight: bold; text-align: left;">{{ $course['name'] ?? 'N/A' }}</td>
                        <td style="text-align: center;">{{ $course['chance'] ?? 'N/A' }}</td>
                        <td style="text-align: center;">{{ $course['year'] ?? 'N/A' }}</td>
                        <td>{{ $course['authority'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center; color: #999; padding: 20px;">No promotion training records found.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p style="font-weight: bold; text-decoration: overline;">Administrative Approval Signature</p>
        <p style="font-size: 10px; color: #666;">Generated on: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

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
                    <th colspan="4" style="background: #333; color: white;">নি ফায়ারিং (Ni Firing - STH) ফলাফল</th>
                </tr>
                <tr>
                    <th>গ্রুপিং (Grouping)</th>
                    <th>হিট (Hit)</th>
                    <th>ইটিএস (ETS)</th>
                    <th>মোট পয়েন্ট (Total)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $soldier->shoot_ret ?? '0' }}</td>
                    <td>{{ $soldier->shoot_ap ?? '0' }}</td>
                    <td>{{ $soldier->shoot_ets ?? '0' }}</td>
                    <td style="font-weight: bold;">{{ $soldier->shoot_total ?? '0' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        <table class="trg-table">
            <thead>
                <tr>
                    <th>গ্রেনেড ফায়ারিং (Grenade)</th>
                    <th>স্পিড মার্চ (Speed March)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $soldier->grenade_fire ?? '0/4' }}</td>
                    <td>{{ $soldier->speed_march ?? '0/4' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer" style="position: fixed; bottom: 0; width: 100%;">
        <span class="restricted">ব্যক্তিগত (RESTRICTED)</span>
    </div>
</body>
</html>
