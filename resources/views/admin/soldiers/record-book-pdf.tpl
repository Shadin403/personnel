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
        .section-block {
            page-break-inside: avoid;
            margin-bottom: 20px;
        }
        .page-break {
            page-break-before: always;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        thead {
            display: table-header-group;
        }
    </style>
</head>
<body>
    <div style="text-align: center; font-weight: bold; font-size: 10px; margin-bottom: 15px; color: #dc3545;">RESTRICTED</div>

    <table style="width: 100%; margin-bottom: 20px; border: none;">
        <tr>
            <td style="vertical-align: top; border: none;">
                <div style="font-size: 14px; font-weight: bold; text-transform: uppercase; color: #000; border-bottom: 3px solid #000; display: inline-block; padding-bottom: 5px;">
                    ডিজিটাল প্রশিক্ষণ কার্ড (Digital Training Card)
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

    <!-- SEC-01 & SEC-02: Identity -->
    <div class="section-header">SEC-01: Personal Information [ব্যক্তিগত তথ্য]</div>
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
            <th>ভর্তির তারিখ (Join Date):</th>
            <td>{{ $soldier->enrolment_date ? $soldier->enrolment_date->format('d M Y') : 'N/A' }}</td>
            <th>পদের তারিখ (Rank Date):</th>
            <td>{{ $soldier->rank_date ? $soldier->rank_date->format('d M Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>ইউনিট (Unit):</th>
            <td>{{ $soldier->battalion_name }}</td>
            <th>কোম্পানী (Coy):</th>
            <td>{{ $soldier->company ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>প্লাটুন (Platoon):</th>
            <td>{{ $soldier->platoon ?? 'N/A' }}</td>
            <th>সেকশন (Section):</th>
            <td>{{ $soldier->section ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>জাতিয় পরিচয়পত্র নং (NID):</th>
            <td>{{ $soldier->nid ?? 'N/A' }}</td>
            <th>লিঙ্গ (Gender):</th>
            <td>{{ $soldier->gender ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>ধর্ম (Religion):</th>
            <td>{{ $soldier->religion ?? 'N/A' }}</td>
            <th>স্ত্রীর নাম (Spouse):</th>
            <td>{{ $soldier->spouse_name ?? 'N/A' }}</td>
        </tr>
    </table>


    <!-- SEC-02: Individual Chain of Command [ব্যক্তিগত তথ্য] -->
    <!--<div class="section-header">SEC-02: Individual Chain of Command [ব্যক্তিগত তথ্য]</div>-->


    <!-- SEC-03: Tactical Training Records -->
    <div class="section-header">SEC-03: Individual Training Records [ব্যক্তিগত প্রশিক্ষণ রেকর্ড]</div>

    <div class="section-block">
        <!-- 3.1 & 3.2: IPFT & RET Firing -->
        <div style="margin-top: 10px; font-weight: bold;">3.1 Individual Physical Fitness Training (IPFT) [শারীরিক সক্ষমতা]</div>
        <table class="data-table">
            <tr>
                <th style="width: 50%;">Biannual 01 (জানুয়ারি - জুন):</th>
                <td>{{ $soldier->ipft_biannual_1 ?? '---' }}</td>
            </tr>
            <tr>
                <th>Biannual 02 (জুলাই - ডিসেম্বর):</th>
                <td>{{ $soldier->ipft_biannual_2 ?? '---' }}</td>
            </tr>
        </table>
    </div>

    <div class="section-block">
        <div style="margin-top: 10px; font-weight: bold;">3.2 RET Firing [আরইটি ফায়ারিং]</div>
        <table class="grid-table" style="font-size: 10px;">
            <thead>
                <tr>
                    <th style="width: 30px;">Sl</th>
                    <th>Firing Date</th>
                    <th>Grouping</th>
                <th>Hit</th>
                <th>ETS</th>
                <th>Status</th>
                <th>Mark</th>
            </tr>
        </thead>
        <tbody>
            @forelse($soldier->firing_records ?? [] as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record['date'] ?? '---' }}</td>
                    <td>{{ $record['grouping'] ?? '---' }}</td>
                    <td>{{ $record['hit'] ?? '---' }}</td>
                    <td>{{ $record['ets'] ?? '---' }}</td>
                    <td style="text-transform: uppercase;">{{ $record['status'] ?? '---' }}</td>
                    <td style="font-weight: bold;">{{ $record['total'] ?? '---' }}</td>
                </tr>
            @empty
                <tr><td colspan="7">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="section-block">
    <div style="margin-top: 10px; font-weight: bold;">3.3 Night Firing [নাইট ফায়ারিং]</div>
    <table class="grid-table" style="font-size: 10px;">
        <thead>
            <tr>
                <th style="width: 30px;">Sl</th>
                <th>Date</th>
                <th>Hit</th>
                <th>Status (P/F)</th>
                <th>Mark</th>
            </tr>
        </thead>
        <tbody>
            @forelse($soldier->night_firing_records ?? [] as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record['date'] ?? '---' }}</td>
                    <td>{{ $record['hit'] ?? '---' }}</td>
                    <td style="text-transform: uppercase;">{{ $record['status'] ?? '---' }}</td>
                    <td style="font-weight: bold;">{{ $record['total'] ?? '---' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="section-block">
    <div style="margin-top: 10px; font-weight: bold;">3.4 & 3.5 Spd March / Grenade</div>
    <table class="data-table">
        <tr>
            <th style="width: 50%;">3.4 Speed March [স্পিড মার্চ]:</th>
            <td>{{ $soldier->speed_march ?? '---' }}</td>
        </tr>
        <tr>
            <th>3.5 Grenade Fire [গ্রেনেড ফায়ার]:</th>
            <td>{{ $soldier->grenade_fire ?? '---' }}</td>
        </tr>
    </table>
    </div>

    <div class="section-block">
    <div style="margin-top: 10px; font-weight: bold;">3.6 Night Training [রাত্রীকালীন প্রশিক্ষণ]</div>
    <table class="grid-table" style="font-size: 10px;">
        <thead>
            <tr>
                <th style="width: 30px;">Sl</th>
                <th>Date</th>
                <th>Appointment during Trg</th>
            </tr>
        </thead>
        <tbody>
            @forelse($soldier->night_trainings ?? [] as $index => $nt)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $nt['date'] ?? '---' }}</td>
                    <td>{{ $nt['appointment'] ?? '---' }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="section-block">
    <div style="margin-top: 10px; font-weight: bold;">3.7 & 3.8 GP Trg / Cycle Ending</div>
    <table class="grid-table" style="font-size: 10px;">
        <tr>
            <td style="width: 50%; vertical-align: top; padding: 0; border: none;">
                <div style="font-weight: bold; margin-bottom: 5px;">3.7 Group Training</div>
                <table class="grid-table">
                    <tr><th>Cycle</th><th>Year</th><th>Appointment</th></tr>
                    @forelse($soldier->group_trainings ?? [] as $gt)
                        <tr>
                            <td>{{ $gt['circle'] ?? '---' }} Cycle</td>
                            <td>{{ $gt['year'] ?? '---' }}</td>
                            <td>{{ $gt['appointment'] ?? '---' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3">N/A</td></tr>
                    @endforelse
                </table>
            </td>
            <td style="vertical-align: top; padding: 0 0 0 10px; border: none;">
                <div style="font-weight: bold; margin-bottom: 5px;">3.8 Cycle Ending Exercise</div>
                <table class="grid-table">
                    <tr><th>Cycle</th><th>Year</th><th>Appointment</th></tr>
                    @forelse($soldier->cycle_ending_exercises ?? [] as $ce)
                        <tr>
                            <td>{{ $ce['circle'] ?? '---' }} Cycle</td>
                            <td>{{ $ce['year'] ?? '---' }}</td>
                            <td>{{ $ce['appointment'] ?? '---' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3">N/A</td></tr>
                    @endforelse
                </table>
            </td>
        </tr>
    </table>
    </div>

    <div class="section-block">
    <div style="margin-top: 10px; font-weight: bold;">3.9 Summer Training [গ্রীষ্মকালীন প্রশিক্ষণ]</div>
    <table class="grid-table" style="font-size: 10px;">
        <thead>
            <tr>
                <th style="width: 30px;">ক্রঃ (Sl)</th>
                <th>বছর (Year)</th>
                <th>ইউনিট (Unit)</th>
                <th>নিযুক্তি (Appoint)</th>
                <th>অর্জিত মান/মন্তব্য (Standard)</th>
                <th>স্বাক্ষর (Sign)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($soldier->field_trainings_summer ?? [] as $index => $trg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $trg['year'] ?? '---' }}</td>
                    <td style="text-transform: uppercase;">{{ $trg['unit'] ?? '---' }}</td>
                    <td style="text-transform: uppercase;">{{ $trg['appointment'] ?? '---' }}</td>
                    <td>{{ $trg['remarks'] ?? '---' }}</td>
                    <td><span style="border-bottom: 1px dashed #ccc; display: block; height: 10px; width: 50px; margin: 0 auto;"></span></td>
                </tr>
            @empty
                <tr><td colspan="6">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="section-block">
    <div style="margin-top: 10px; font-weight: bold;">3.10 Winter Training [শীতকালীন প্রশিক্ষণ]</div>
    <table class="grid-table" style="font-size: 10px;">
        <thead>
            <tr>
                <th style="width: 30px;">ক্রঃ (Sl)</th>
                <th>বছর (Year)</th>
                <th>ইউনিট (Unit)</th>
                <th>নিযুক্তি (Appoint)</th>
                <th>অর্জিত মান/মন্তব্য (Standard)</th>
                <th>স্বাক্ষর (Sign)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($soldier->field_trainings_winter ?? [] as $index => $trg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $trg['year'] ?? '---' }}</td>
                    <td style="text-transform: uppercase;">{{ $trg['unit'] ?? '---' }}</td>
                    <td style="text-transform: uppercase;">{{ $trg['appointment'] ?? '---' }}</td>
                    <td>{{ $trg['remarks'] ?? '---' }}</td>
                    <td><span style="border-bottom: 1px dashed #ccc; display: block; height: 10px; width: 50px; margin: 0 auto;"></span></td>
                </tr>
            @empty
                <tr><td colspan="6">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="section-block">
    <!-- SEC-04: Courses -->
    <div class="section-header">SEC-04: Promotion Training & Courses [প্রশিক্ষণ ও কোর্স]</div>
    <table class="grid-table" style="font-size: 10px;">
        <thead><tr><th style="width: 30px;">Sl</th><th>Course Name</th><th>Chance</th><th>Year</th><th>Details</th></tr></thead>
        <tbody>
            @forelse($soldier->courses ?? [] as $index => $course)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">
                        @if(isset($course['group']))
                            <div style="font-size: 8px; color: #666; font-weight: bold;">{{ $course['group'] }}</div>
                        @endif
                        {{ $course['name'] ?? '---' }}
                    </td>
                    <td>{{ $course['chance'] ?? '---' }}</td>
                    <td>{{ $course['year'] ?? '---' }}</td>
                    <td>{{ $course['authority'] ?? '---' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No verified records found.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="section-block">
    <!-- SEC-05: Special Training -->
    <div class="section-header">SEC-05: Army level course/cadre & special training [বিশেষ প্রশিক্ষণ]</div>
    <table class="grid-table" style="font-size: 10px;">
        <thead><tr><th style="width: 30px;">Sl</th><th>Year</th><th>Course/Cadre</th><th>Inst/Unit</th><th>Details</th></tr></thead>
        <tbody>
            @forelse($soldier->special_courses ?? [] as $index => $scourse)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $scourse['year'] ?? '---' }}</td>
                    <td style="text-align: left;">{{ $scourse['name'] ?? '---' }}</td>
                    <td>{{ $scourse['unit'] ?? '---' }}</td>
                    <td>{{ $scourse['details'] ?? '---' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No training records found.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="section-block">
    <!-- SEC-06: Annual Career Plan [বাৎসরিক পেশা পরিকল্পনা] -->
    <div class="section-header">SEC-06: Annual Career Plan [বাৎসরিক পেশা পরিকল্পনা]</div>
    <table class="grid-table" style="font-size: 9px;">
        <thead>
            <tr>
                <th style="width: 30px;">Sl</th>
                <th>Year</th>
                <th>Leave</th>
                <th>Unit Trg</th>
                <th>Personal</th>
                <th>Admin</th>
                <th>MOOTW</th>
                <th>Sign</th>
            </tr>
        </thead>
        <tbody>
            @forelse($soldier->annual_career_plans ?? [] as $index => $plan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $plan['year'] ?? '---' }}</td>
                    <td>{{ $plan['leave'] ?? '---' }}</td>
                    <td>{{ $plan['unit_trg'] ?? '---' }}</td>
                    <td>{{ $plan['personal_trg'] ?? '---' }}</td>
                    <td>{{ $plan['admin'] ?? '---' }}</td>
                    <td>{{ $plan['mootw'] ?? '---' }}</td>
                    <td>{{ $plan['signature'] ?? '---' }}</td>
                </tr>
            @empty
                <tr><td colspan="8">No trajectory records found.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="section-block">
    <!-- SEC-07: Sports Participation -->
    <div class="section-header">SEC-07: Sports Participation [খেলাধুলা ও অন্যান্য]</div>
    <div style="border: 1px solid #dee2e6; padding: 15px; font-weight: bold; text-align: left; font-size: 12px; min-height: 100px;">
        {!! nl2br(e($soldier->sports_participation)) !!}
    </div>
    </div>

    <div class="section-block">
    <!-- SEC-08: Physical Measurements -->
    <div class="section-header">SEC-08: Physical & Obesity Analysis [শারীরিক বিশ্লেষণ]</div>
    <table class="data-table">
        <tr>
            <th style="width: 25%; font-weight: bold; background: #f1f3f5;">উচ্চতা (Height):</th>
            <td>{{ $soldier->height_inch ? floor($soldier->height_inch / 12) . '\'' . ($soldier->height_inch % 12) . '"' : '---' }} ({{ number_format(($soldier->height_inch ?? 0) * 2.54, 1) }} CM)</td>
            <th style="width: 25%; font-weight: bold; background: #f1f3f5;">ওজন (Weight):</th>
            <td>{{ $soldier->weight ?? '---' }} KG</td>
        </tr>
        <tr>
            <th style="font-weight: bold; background: #f1f3f5;">স্ট্যান্ডার্ড ওজন (Standard):</th>
            <td>{{ number_format($soldier->standard_weight, 1) }} KG</td>
            <th style="font-weight: bold; background: #f1f3f5;">বর্তমান অবস্থা (Status):</th>
            <td style="text-transform: uppercase; font-weight: 900; font-size: 14px; {{ in_array($soldier->weight_status, ['Obese', 'Obese (WHR)']) ? 'color: #dc3545;' : ($soldier->weight_status == 'Overweight' ? 'color: #ffc107;' : 'color: #198754;') }}">
                {{ $soldier->weight_status }}
            </td>
        </tr>
    </table>
    </div>
    </div>

    <div style="position: fixed; bottom: 0px; width: 100%; text-align: center; font-size: 10px; font-weight: bold; color: #dc3545;">
        RESTRICTED
    </div>
</body>
</html>
