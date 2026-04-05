<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 0.5in; }
        body { font-family: 'nikosh', sans-serif; line-height: 1.4; color: #1a1a1a; font-size: 11px; }
        .page-break { page-break-after: always; }
        .header-restricted { text-align: center; font-weight: bold; text-transform: uppercase; font-size: 9px; color: #666; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .main-title { text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 5px; color: #000; }
        .photo-container { float: right; width: 120px; height: 145px; border: 2px solid #333; margin-left: 20px; margin-bottom: 20px; background: #f9f9f9; }
        .photo-container img { width: 100%; height: 100%; object-fit: cover; }
        .section-header { background: #f1f3f5; padding: 8px 12px; font-weight: bold; margin: 25px 0 10px 0; border-left: 5px solid #000; text-transform: uppercase; font-size: 13px; clear: both; color: #000; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th { text-align: left; width: 25%; padding: 10px 12px; background: #f8f9fa; border: 1px solid #dee2e6; color: #495057; font-size: 11px; font-weight: normal; }
        .data-table td { padding: 10px 12px; border: 1px solid #dee2e6; font-weight: bold; color: #212529; font-size: 12px; }
        .grid-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .grid-table th { background: #343a40; color: #ffffff; padding: 10px; font-size: 11px; border: 1px solid #343a40; text-align: center; }
        .grid-table td { padding: 10px; border: 1px solid #dee2e6; text-align: center; color: #212529; }
        .section-block { page-break-inside: avoid; margin-bottom: 20px; }
    </style>
</head>
<body>
    @foreach($soldiers as $soldier)
        <div class="{{ !$loop->last ? 'page-break' : '' }}">
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
                                <img src="{{ public_path('storage/' . $soldier->photo) }}" style="width: 120px; height: 145px; display: block;">
                            @else
                                <div style="width: 120px; height: 145px; line-height: 145px; text-align: center; color: #adb5bd; border: 1px dashed #dee2e6; font-size: 10px;">PHOTO (ছবি)</div>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Identiy Section -->
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
            </table>

            <!-- Training Records -->
            <div class="section-header">SEC-03: Training Records [প্রশিক্ষণ রেকর্ড]</div>
            <table class="data-table">
                <tr>
                    <th style="width: 50%;">IPFT FAIL [Biannual 01]:</th>
                    <td>{{ $soldier->ipft_biannual_1 ?? '---' }}</td>
                </tr>
                <tr>
                    <th style="width: 50%;">IPFT FAIL [Biannual 02]:</th>
                    <td>{{ $soldier->ipft_biannual_2 ?? '---' }}</td>
                </tr>
                <tr>
                    <th>RET FAIL:</th>
                    <td>{{ $soldier->ret_status ?? '---' }}</td>
                </tr>
                <tr>
                    <th>Speed March:</th>
                    <td>{{ $soldier->speed_march ?? '---' }}</td>
                </tr>
                <tr>
                    <th>Grenade Fire:</th>
                    <td>{{ $soldier->grenade_fire ?? '---' }}</td>
                </tr>
            </table>

            <!-- Physical Measurements -->
            <div class="section-header">SEC-08: Physical & Obesity Analysis [শারীরিক বিশ্লেষণ]</div>
            <table class="data-table">
                <tr>
                    <th>উচ্চতা (Height):</th>
                    <td>{{ $soldier->height_inch ? floor($soldier->height_inch / 12) . '\'' . ($soldier->height_inch % 12) . '"' : '---' }}</td>
                    <th>ওজন (Weight):</th>
                    <td>{{ $soldier->weight ?? '---' }} KG</td>
                </tr>
                <tr>
                    <th>বর্তমান অবস্থা (Status):</th>
                    <td colspan="3" style="text-transform: uppercase; font-weight: 900; font-size: 14px; {{ in_array($soldier->weight_status, ['Obese', 'Obese (WHR)']) ? 'color: #dc3545;' : ($soldier->weight_status == 'Overweight' ? 'color: #ffc107;' : 'color: #198754;') }}">
                        {{ $soldier->weight_status }}
                    </td>
                </tr>
            </table>

            <div style="text-align: center; font-size: 10px; font-weight: bold; color: #dc3545; margin-top: 20px;">
                RESTRICTED
            </div>
        </div>
    @endforeach
</body>
</html>
