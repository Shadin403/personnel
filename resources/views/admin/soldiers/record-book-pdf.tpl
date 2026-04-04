<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 0.5in;
        }
        body {
            font-family: 'nikosh', sans-serif;
            line-height: 1.4;
            color: #1a1a1a;
            font-size: 11px;
        }
        .header-restricted {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            color: #666;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .restricted-box {
            border: 1px solid #ccc;
            padding: 2px 12px;
            display: inline-block;
        }
        .main-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000;
        }
        .sub-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            text-transform: uppercase;
        }
        .photo-container {
            float: right;
            width: 120px;
            height: 145px;
            border: 2px solid #333;
            margin-left: 20px;
            margin-bottom: 20px;
            background: #f9f9f9;
        }
        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .section-header {
            background: #f0f4f2;
            padding: 6px 12px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            border-left: 6px solid #2F4F3E;
            text-transform: uppercase;
            font-size: 12px;
            clear: both;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .data-table th {
            text-align: left;
            width: 30%;
            padding: 6px 8px;
            background: #fafafa;
            border: 1px solid #e0e0e0;
            color: #555;
            font-size: 10px;
        }
        .data-table td {
            padding: 6px 8px;
            border: 1px solid #e0e0e0;
            font-weight: bold;
            color: #000;
        }
        .grid-table {
            width: 100%;
            border-collapse: collapse;
        }
        .grid-table th {
            background: #333;
            color: #fff;
            padding: 8px;
            font-size: 10px;
            border: 1px solid #000;
            text-align: center;
        }
        .grid-table td {
            padding: 8px;
            border: 1px solid #333;
            text-align: center;
        }
        .footer-note {
            margin-top: 50px;
            font-size: 9px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .bengali {
            font-family: 'nikosh', sans-serif;
            color: #444;
        }
        .marksman-badge {
            background: #c92a2a;
            color: white;
            padding: 2px 8px;
            font-weight: bold;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="header-restricted">
        <span class="restricted-box">ব্যক্তিগত (RESTRICTED)</span>
    </div>

    <div class="photo-container">
        @if($soldier->photo && file_exists(public_path('storage/' . $soldier->photo)))
            @php
                $imageData = base64_encode(file_get_contents(public_path('storage/' . $soldier->photo)));
                $mimeType = mime_content_type(public_path('storage/' . $soldier->photo));
            @endphp
            <img src="data:{{ $mimeType }};base64,{{ $imageData }}">
        @else
            <div style="line-height: 145px; text-align: center; color: #ccc;">PHOTO</div>
        @endif
    </div>

    <div class="main-title">{{ $soldier->name }}</div>
    <div class="sub-title">Strategic Personnel Record Book (সেনা সদস্যের রেকর্ড বুক)</div>

    <!-- SEC-01: Identity -->
    <div class="section-header">SEC-01: Personnel Identity [মৌলিক তথ্য]</div>
    <table class="data-table">
        <tr>
            <th>সৈনিকের নাম (Full Name):</th>
            <td>{{ $soldier->name }} <span class="bengali">({{ $soldier->name_bn }})</span></td>
            <th>ব্যক্তিগত নং (Personal No):</th>
            <td>{{ $soldier->personal_no }}</td>
        </tr>
        <tr>
            <th>পদবী (Rank):</th>
            <td>{{ $soldier->rank }} <span class="bengali">({{ $soldier->rank_bn }})</span></td>
            <th>সেনা নং (Service No):</th>
            <td>{{ $soldier->number }}</td>
        </tr>
    </table>

    <!-- SEC-02: Chain of Command -->
    <div class="section-header">SEC-02: Tactical Chain of Command [কমান্ড চেইন]</div>
    <table class="data-table">
        <tr>
            <th>ইউনিট (Unit/Regiment):</th>
            <td colspan="3">{{ $soldier->battalion_name }}</td>
        </tr>
        <tr>
            <th>কোয়েচ গ্রুপ (Company):</th>
            <td>{{ $soldier->company ?? 'N/A' }}</td>
            <th>প্লাটুন (Platoon):</th>
            <td>{{ $soldier->platoon ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>সেকশন (Section):</th>
            <td>{{ $soldier->section ?? 'N/A' }}</td>
            <th>নিযুক্তি (Appointment):</th>
            <td>{{ $soldier->appointment }} <span class="bengali">({{ $soldier->appointment_bn }})</span></td>
        </tr>
    </table>

    <!-- SEC-03: Military Particulars -->
    <div class="section-header">SEC-03: Military Career Particulars [চাকরির তথ্য]</div>
    <table class="data-table">
        <tr>
            <th>ভর্তির তারিখ (Enrolment Date):</th>
            <td>{{ $soldier->enrolment_date ? $soldier->enrolment_date->format('d M Y') : 'N/A' }}</td>
            <th>পদবী প্রাপ্তি (Date of Rank):</th>
            <td>{{ $soldier->rank_date ? $soldier->rank_date->format('d M Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>ব্যাচ (Batch):</th>
            <td>{{ $soldier->batch ?? 'N/A' }}</td>
            <th>রক্তের গ্রুপ (Blood Group):</th>
            <td>{{ $soldier->blood_group }}</td>
        </tr>
    </table>

    <!-- SEC-04: Personal Detail -->
    <div class="section-header">SEC-04: Personal Profile & Bio-data [ব্যক্তিগত তথ্য]</div>
    <table class="data-table">
        <tr>
            <th>পিতার নাম (Father's Name):</th>
            <td>{{ $soldier->father_name ?? 'N/A' }}</td>
            <th>মাতার নাম (Mother's Name):</th>
            <td>{{ $soldier->mother_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>স্ত্রীর নাম (Spouse Name):</th>
            <td>{{ $soldier->spouse_name ?? 'N/A' }}</td>
            <th>জন্ম তারিখ (DOB):</th>
            <td>{{ $soldier->dob ? $soldier->dob->format('d M Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>এনআইডি (NID No):</th>
            <td>{{ $soldier->nid ?? 'N/A' }}</td>
            <th>উচ্চতা ও ওজন (Height/Weight):</th>
            <td>{{ $soldier->height }} / {{ $soldier->weight }}</td>
        </tr>
        <tr>
            <th>ধর্ম (Religion):</th>
            <td>{{ $soldier->religion ?? 'N/A' }}</td>
            <th>বৈবাহিক অবস্থা (Status):</th>
            <td>{{ $soldier->marital_status ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- SEC-05: Location -->
    <div class="section-header">SEC-05: Geographic Trace [স্থায়ী ঠিকানা]</div>
    <table class="data-table">
        <tr>
            <th>হোম ডিস্ট্রিক্ট (District):</th>
            <td>{{ $soldier->home_district ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>স্থায়ী ঠিকানা (Address):</th>
            <td>{{ $soldier->permanent_address ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- SEC-06: Career Plan -->
    <div class="section-header">SEC-06: Strategic Career Trajectory [বাৎসরিক পেশা পরিকল্পনা]</div>
    <table class="grid-table">
        <thead>
            <tr>
                <th>Phase</th>
                <th>Year</th>
                <th>Trade / Specialty</th>
                <th>Re-engagement</th>
                <th>Strategic Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php $plans = $soldier->annual_career_plans ?? []; @endphp
            @for($i = 0; $i < 5; $i++)
                @php $plan = $plans[$i] ?? null; @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $plan['year'] ?? '' }}</td>
                    <td>{{ $plan['trade'] ?? '' }}</td>
                    <td>{{ $plan['re_engagement'] ?? '' }}</td>
                    <td style="text-align: left;">{{ $plan['remarks'] ?? '' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <!-- SEC-07: Combat Readiness -->
    <div class="section-header">SEC-07: Combat Readiness & Performance [প্রশিক্ষণ ও ফায়ারিং]</div>
    <table class="data-table" style="margin-bottom: 5px;">
        <tr>
            <th colspan="2" style="background: #eee; text-align: center;">IPFT RESULTS</th>
            <th colspan="2" style="background: #eee; text-align: center;">FIRING ANALYTICS (STH)</th>
        </tr>
        <tr>
            <th>Cycle 01:</th>
            <td>{{ $soldier->ipft_biannual_1 ?? 'N/A' }}</td>
            <th>Marksman Tier:</th>
            <td><span class="marksman-badge">{{ $soldier->shooting_grade }}</span></td>
        </tr>
        <tr>
            <th>Cycle 02:</th>
            <td>{{ $soldier->ipft_biannual_2 ?? 'N/A' }}</td>
            <th>Total Score:</th>
            <td style="font-size: 14px;">{{ $soldier->shoot_total ?? '0' }}</td>
        </tr>
    </table>
    <table class="grid-table">
        <tr>
            <th>Hit</th>
            <th>AP</th>
            <th>ETS</th>
            <th>Speed March</th>
            <th>Grenade</th>
        </tr>
        <tr>
            <td>{{ $soldier->shoot_ret ?? '0' }}</td>
            <td>{{ $soldier->shoot_ap ?? '0' }}</td>
            <td>{{ $soldier->shoot_ets ?? '0' }}</td>
            <td>{{ $soldier->speed_march ?? '0/4' }}</td>
            <td>{{ $soldier->grenade_fire ?? '0/4' }}</td>
        </tr>
    </table>

    <!-- SEC-08: Financial -->
    <div class="section-header">SEC-08: Financial Details [আর্থিক তথ্য]</div>
    <table class="data-table">
        <tr>
            <th>ব্যাংকের নাম (Bank Name):</th>
            <td colspan="3">{{ $soldier->bank_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>শাখা (Branch):</th>
            <td>{{ $soldier->branch_name ?? 'N/A' }}</td>
            <th>অ্যাকাউন্ট নং (AC No):</th>
            <td>{{ $soldier->ac_no ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="footer-note">
        <p>This is a strategically generated personnel record book. All data is restricted for official use only.</p>
        <p>Generated Date: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

    <div style="position: fixed; bottom: -20px; width: 100%; text-align: center; font-size: 9px; color: #666;">
        ব্যক্তিগত (RESTRICTED)
    </div>
</body>
</html>
