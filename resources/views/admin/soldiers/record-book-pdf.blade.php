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
            border: 1px solid #000;
            text-align: center;
            line-height: 120px;
            font-size: 10px;
            color: #999;
        }
        .section {
            margin-bottom: 20px;
            clear: both;
        }
        .field {
            margin-bottom: 10px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 2px;
        }
        .label {
            font-weight: bold;
            margin-right: 10px;
        }
        .value {
            font-style: italic;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f5f5f5;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <span class="restricted">সীমিত (RESTRICTED)</span>
    </div>

    <div class="photo-box">
        @if($soldier->photo)
            {{-- Note: Dompdf sometimes has issues with relative paths, absolute local path is safer --}}
            <img src="{{ public_path('storage/' . $soldier->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
            ছবির ঘর
        @endif
    </div>

    <div class="title">ব্যক্তিগত তথ্যাবলী (PERSONAL INFORMATION)</div>

    <div class="section">
        <div class="field"><span class="label">১। ব্যক্তিগত নং (Personal No):</span> <span class="value">{{ $soldier->number }}</span></div>
        <div class="field"><span class="label">২। পদবী (Rank):</span> <span class="value">{{ $soldier->rank }}</span></div>
        <div class="field"><span class="label">৩। নাম (Name):</span> <span class="value">{{ $soldier->name }}</span></div>
        <div class="field"><span class="label">৪। নিযুক্তি (Appointment):</span> <span class="value">{{ $soldier->appointment }}</span></div>
        <div class="field"><span class="label">৫। ইউনিট/সাব ইউনিট (Unit/Sub Unit):</span> <span class="value">{{ $soldier->unit ?? $soldier->company }} / {{ $soldier->sub_unit }}</span></div>
        <div class="field"><span class="label">৬। ভর্তির তাং (Date of Enrolment):</span> <span class="value">{{ $soldier->enrolment_date }}</span></div>
        <div class="field"><span class="label">৭। পদের তাং (Date of Rank):</span> <span class="value">{{ $soldier->rank_date }}</span></div>
        <div class="field"><span class="label">৮। বেসামরিক শিক্ষা (Civil Education):</span> <span class="value">{{ $soldier->civil_education }}</span></div>
        <div class="field"><span class="label">৯। রক্তের গ্রুপ (Blood Group):</span> <span class="value">{{ $soldier->blood_group }}</span></div>
        <div class="field"><span class="label">১০। ওজন (Weight):</span> <span class="value">{{ $soldier->weight }}</span></div>
        <div class="field"><span class="label">১১। স্থায়ী ঠিকানা (Permanent Address):</span> <span class="value">{{ $soldier->permanent_address }}</span></div>
    </div>

    <div class="footer">
        সীমিত (RESTRICTED)
    </div>

    <div class="page-break"></div>

    <div class="header">
        <span class="restricted">সীমিত (RESTRICTED)</span>
    </div>

    <div class="title">প্রশিক্ষণ ও কোর্স হিস্ট্রি (COURSE HISTORY)</div>
    <table>
        <thead>
            <tr>
                <th>ক্রমিক (SL)</th>
                <th>প্রশিক্ষণ ও কোর্স/ক্যাডার (Course/Cadre)</th>
                <th>সুযোগ (Chance)</th>
                <th>সাল (Year)</th>
                <th>ফলাফল (Result)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soldier->courses as $index => $course)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->chance }}</td>
                    <td>{{ $course->year }}</td>
                    <td>{{ $course->result }}</td>
                </tr>
            @endforeach
            {{-- Padding empty rows to look like the book --}}
            @for($i = count($soldier->courses); $i < 10; $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="page-break"></div>

    <div class="header">
        <span class="restricted">সীমিত (RESTRICTED)</span>
    </div>

    <div class="title">অপারেশনাল মেট্রিকস / টিআরজি কার্ড (OPERATIONAL METRICS / TRG CARD)</div>
    <table>
        <thead>
            <tr>
                <th>আইটেম (Item)</th>
                <th>ফলাফল/মেট্রিক্স (Result / Metrics)</th>
                <th>মন্তব্য (Remarks)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="label">আইপিএফটি অর্ধবার্ষিক-১ (IPFT Biannual-1)</td>
                <td>{{ $soldier->ipft_biannual_1 }}</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="label">আইপিএফটি অর্ধবার্ষিক-২ (IPFT Biannual-2)</td>
                <td>{{ $soldier->ipft_biannual_2 }}</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="label">স্পিড মার্চ (Speed March)</td>
                <td>{{ $soldier->speed_march }}</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="label">নি ফায়ারিং (Ni firing - STH)</td>
                <td>{{ $soldier->shoot_ret }} / {{ $soldier->shoot_total }}</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="label">গ্রেনেড ফায়ারিং (Grenade firing)</td>
                <td>{{ $soldier->grenade_fire }}</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        সীমিত (RESTRICTED)
    </div>

    <div class="footer">
        সীমিত (RESTRICTED)
    </div>
</body>
</html>
