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
            background: #f1f3f5;
            padding: 8px 12px;
            font-weight: bold;
            margin: 25px 0 10px 0;
            border-left: 5px solid #000;
            text-transform: uppercase;
            font-size: 13px;
            clear: both;
            color: #000;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th {
            text-align: left;
            width: 25%;
            padding: 10px 12px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #495057;
            font-size: 11px;
            font-weight: normal;
        }
        .data-table td {
            padding: 10px 12px;
            border: 1px solid #dee2e6;
            font-weight: bold;
            color: #212529;
            font-size: 12px;
        }
        .grid-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .grid-table th {
            background: #343a40;
            color: #ffffff;
            padding: 10px;
            font-size: 11px;
            border: 1px solid #343a40;
            text-align: center;
        }
        .grid-table td {
            padding: 10px;
            border: 1px solid #dee2e6;
            text-align: center;
            color: #212529;
        }
    </style>
</head>
<body>
    <div style="text-align: center; font-weight: bold; font-size: 10px; margin-bottom: 15px; color: #dc3545;">গোপনীয় / RESTRICTED</div>

    <table style="width: 100%; margin-bottom: 20px; border: none;">
        <tr>
            <td style="vertical-align: top; border: none;">
                <!--<div style="font-size: 24px; font-weight: bold; color: #000; margin-bottom: 5px;">{{ $soldier->name }}</div>
                <div style="font-size: 18px; font-weight: bold; color: #495057; margin-bottom: 10px;">{{ $soldier->name_bn }}</div>-->
                <div style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: #000; border-bottom: 3px solid #000; display: inline-block; padding-bottom: 5px;">
                    ডিজিটাল রেকর্ড বুক (Digital Personnel Record)
                </div>
            </td>
            <td style="vertical-align: top; width: 130px; text-align: right; border: none;">
                <div class="photo-container" style="width: 120px; height: 145px; border: 3px solid #000; margin: 0; padding: 0; float: right; background: #fff;">
                    @if($soldier->photo && file_exists(public_path('storage/' . $soldier->photo)))
                        @php
                            $imageData = base64_encode(file_get_contents(public_path('storage/' . $soldier->photo)));
                            $mimeType = mime_content_type(public_path('storage/' . $soldier->photo));
                        @endphp
                        <img src="data:{{ $mimeType }};base64,{{ $imageData }}" style="width: 120px; height: 145px; display: block;">
                    @else
                        <div style="width: 120px; height: 145px; line-height: 145px; text-align: center; color: #adb5bd; border: 1px dashed #dee2e6; font-size: 10px;">PHOTO (ছবি)</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- SEC-01: Identity -->
    <div class="section-header">SEC-01: Personnel Identity [গোপনীয় তথ্য ]</div>
    <table class="data-table">
        <tr>
            <th>ব্যক্তিগত নং (Personal No):</th>
            <td>{{ $soldier->personal_no }}</td>
            <th>পদবী (Rank):</th>
            <td>{{ $soldier->rank }} ({{ $soldier->rank_bn }})</td>
        </tr>
        <tr>
            <th>সৈনিকের নাম (Full Name):</th>
            <td colspan="3">{{ $soldier->name }} ({{ $soldier->name_bn }})</td>
        </tr>
        <tr>
            <th>নিযুক্তি (Appointment):</th>
            <td>{{ $soldier->appointment }} ({{ $soldier->appointment_bn }})</td>
            <th>ইউনিট (Unit):</th>
            <td>{{ $soldier->battalion_name }} / {{ $soldier->company ?? 'N/A' }} / {{ $soldier->platoon ?? 'N/A' }} / {{ $soldier->section ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>ভর্তির তারিখ (Join Date):</th>
            <td>{{ $soldier->enrolment_date ? $soldier->enrolment_date->format('d M Y') : 'N/A' }}</td>
            <th>পদের তারিখ (Rank Date):</th>
            <td>{{ $soldier->rank_date ? $soldier->rank_date->format('d M Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>বেসামরিক শিক্ষা (Civil Edu):</th>
            <td>{{ $soldier->civil_education ?? 'N/A' }}</td>
            <th>রক্তের গ্রুপ (Blood Group):</th>
            <td>{{ $soldier->blood_group }}</td>
        </tr>
        <tr>
            <th>ওজন (Weight):</th>
            <td>{{ $soldier->weight ?? 'N/A' }} KG</td>
            <th>ব্যাচ (Batch):</th>
            <td>{{ $soldier->batch ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>স্থায়ী ঠিকানা (Address):</th>
            <td colspan="3">{{ $soldier->home_district }}, {{ $soldier->permanent_address ?? 'N/A' }}</td>
        </tr>
    </table>



    <!-- SEC-02: Personal Detail -->
    <div class="section-header">SEC-02: Personal Profile & Bio-data [ব্যক্তিগত তথ্য]</div>
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
            <th>ধর্ম (Religion):</th>
            <td>{{ $soldier->religion ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>বৈবাহিক অবস্থা (Status):</th>
            <td>{{ $soldier->marital_status ?? 'N/A' }}</td>
            <th>স্থায়ী ঠিকানা (Permanent Address):</th>
            <td>{{ $soldier->home_district }}, {{ $soldier->permanent_address ?? 'N/A' }}</td>
        </tr>
    </table>

     <!-- SEC-03: Annual Career Plan -->
    <div class="section-header">SEC-03: Annual Career Plan [বাৎসরিক পেশা পরিকল্পনা]</div>
    <table class="grid-table" style="font-size: 9px;">
        <thead>
            <tr>
                <th style="width: 30px;">বছর<br>(Year)</th>
                <th>ছুটি<br>(Leave)</th>
                <th>ইউনিট প্রশিক্ষণ<br>(Unit Trg)</th>
                <th>ব্যক্তিগত প্রশিক্ষণ<br>(Pers Trg)</th>
                <th>প্রশাসন<br>(Admin)</th>
                <th>MOOTW</th>
                <th>স্বাক্ষর<br>(Sign)</th>
            </tr>
        </thead>
        <tbody>
            @php $plans = $soldier->annual_career_plans ?? []; @endphp
            @forelse($plans as $plan)
                <tr>
                    <td>{{ $plan['year'] ?? '' }}</td>
                    <td>{{ $plan['leave'] ?? '' }}</td>
                    <td>{{ $plan['unit_trg'] ?? '' }}</td>
                    <td>{{ $plan['personal_trg'] ?? '' }}</td>
                    <td>{{ $plan['admin'] ?? '' }}</td>
                    <td>{{ $plan['mootw'] ?? '' }}</td>
                    <td>{{ $plan['signature'] ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="color: #999;">No career plans found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SEC-04: Promotion Training -->
    <div class="section-header">SEC-04: Promotion Training & Courses [প্রশিক্ষণ ও কোর্স]</div>
    <table class="grid-table">
        <thead>
            <tr>
                <th style="width: 40px;">ক্র:<br>(Sl)</th>
                <th>প্রশিক্ষণ ও কোর্স<br>(Course Name)</th>
                <th style="width: 80px;">সুযোগ<br>(Chance)</th>
                <th style="width: 60px;">সাল<br>(Year)</th>
                <th>ফলাফল ও প্রাধিকার<br>(Result & Details)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($soldier->courses as $index => $course)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">
                        {{ $course->name }}
                        @if($course->group)
                            <span style="font-size: 8px; color: #777; font-weight: normal; margin-left: 5px;">[{{ $course->group }}]</span>
                        @endif
                    </td>
                    <td>{{ $course->chance }}</td>
                    <td>{{ $course->year }}</td>
                    <td style="text-align: left;">{{ $course->authority }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="color: #999;">No promotion training records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SEC-05: Special Training -->
    <div class="section-header">SEC-05: Army/Formation/Unit Level Cadres [বিশেষ প্রশিক্ষণ]</div>
    <table class="grid-table">
        <thead>
            <tr>
                <th style="width: 60px;">সাল<br>(Year)</th>
                <th>কোর্স/ক্যাডার<br>(Course / Cadre Name)</th>
                <th>প্রতিষ্ঠান/ইউনিট<br>(Institution / Unit)</th>
                <th>ফলাফল ও প্রাধিকার<br>(Result & Details)</th>
            </tr>
        </thead>
        <tbody>
            @php $special = $soldier->special_courses ?? []; @endphp
            @forelse($special as $scourse)
                <tr>
                    <td>{{ $scourse['year'] ?? '' }}</td>
                    <td style="text-align: left;">{{ $scourse['name'] ?? '' }}</td>
                    <td>{{ $scourse['unit'] ?? '' }}</td>
                    <td style="text-align: left;">{{ $scourse['details'] ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="color: #999;">No special training records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SEC-06: Summer Training -->
    <div class="section-header">SEC-06: Summer Training [গ্রীষ্মকালীন প্রশিক্ষণ]</div>
    <table class="grid-table">
        <thead>
            <tr>
                <th style="width: 40px;">ক্র:<br>(Sl)</th>
                <th style="width: 60px;">বছর<br>(Year)</th>
                <th>ইউনিট<br>(Unit)</th>
                <th>নিযুক্তি<br>(Appointment)</th>
                <th>অর্জিত মান/মন্তব্য<br>(Remarks)</th>
            </tr>
        </thead>
        <tbody>
            @php $summer = $soldier->field_trainings_summer ?? []; @endphp
            @forelse($summer as $index => $trg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $trg['year'] ?? '' }}</td>
                    <td>{{ $trg['unit'] ?? '' }}</td>
                    <td>{{ $trg['appointment'] ?? '' }}</td>
                    <td style="text-align: left;">{{ $trg['remarks'] ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="color: #999;">No summer training records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SEC-06: Winter Training -->
    <div class="section-header">SEC-06: Winter Training [শীতকালীন প্রশিক্ষণ]</div>
    <table class="grid-table">
        <thead>
            <tr>
                <th style="width: 40px;">ক্র:<br>(Sl)</th>
                <th style="width: 60px;">বছর<br>(Year)</th>
                <th>ইউনিট<br>(Unit)</th>
                <th>নিযুক্তি<br>(Appointment)</th>
                <th>অর্জিত মান/মন্তব্য<br>(Remarks)</th>
            </tr>
        </thead>
        <tbody>
            @php $winter = $soldier->field_trainings_winter ?? []; @endphp
            @forelse($winter as $index => $trg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $trg['year'] ?? '' }}</td>
                    <td>{{ $trg['unit'] ?? '' }}</td>
                    <td>{{ $trg['appointment'] ?? '' }}</td>
                    <td style="text-align: left;">{{ $trg['remarks'] ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="color: #999;">No winter training records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>





    <!-- SEC-08: Combat Readiness -->
    <div class="section-header">SEC-08: Combat Readiness & Performance [যুদ্ধ প্রস্তুতি ও ফলাফল]</div>
    <table class="data-table" style="margin-bottom: 5px;">
        <tr>
            <th colspan="2" style="background: #eee; text-align: center;">FIRING ANALYTICS (STH)</th>
            <th colspan="2" style="background: #eee; text-align: center;">PHYSICAL PROFICIENCY</th>
        </tr>
        <tr>
            <th>Grouping (Ret):</th>
            <td>{{ $soldier->shoot_ret ?? '0' }}</td>
            <th>IPFT Cycle 01:</th>
            <td>{{ $soldier->ipft_biannual_1 ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Hit (AP):</th>
            <td>{{ $soldier->shoot_ap ?? '0' }}</td>
            <th>IPFT Cycle 02:</th>
            <td>{{ $soldier->ipft_biannual_2 ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>ETS Score:</th>
            <td>{{ $soldier->shoot_ets ?? '0' }}</td>
            <th>Speed March:</th>
            <td>{{ $soldier->speed_march ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Night Fire (Nil):</th>
            <td>{{ $soldier->nil_fire ?? 'N/A' }}</td>
            <th>Grenade Fire:</th>
            <td>{{ $soldier->grenade_fire ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Total Score / Grade:</th>
            <td><span style="font-size: 14px;">{{ $soldier->shoot_total ?? '0' }}</span></td>
            <th>Overall Status:</th>
            <td>{{ $soldier->overall_status }}</td>
        </tr>
    </table>

    <!-- SEC-09: Financial -->
    <div class="section-header">SEC-09: Financial Details [আর্থিক তথ্য]</div>
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

    <div style="position: fixed; bottom: 0px; width: 100%; text-align: center; font-size: 10px; font-weight: bold; color: #dc3545;">
        গোপনীয় / RESTRICTED
    </div>
</body>
</html>
