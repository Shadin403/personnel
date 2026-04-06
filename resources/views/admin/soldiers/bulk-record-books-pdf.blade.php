<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 0.3in;
        }
        body {
            font-family: 'nikosh', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }
        .main-container {
            width: 100%;
        }
        .card-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 12px;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 6px solid #ef4444;
            padding: 15px;
            width: 100%;
            vertical-align: top;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .photo-cell {
            width: 70px;
            vertical-align: top;
        }
        .photo {
            width: 70px;
            height: 85px;
            border: 2px solid #f1f5f9;
            background-color: #f8fafc;
        }
        .info-cell {
            padding-left: 12px;
            vertical-align: top;
        }
        .name {
            font-size: 14px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 2px;
            text-transform: uppercase;
        }
        .rank-number {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .tags-container {
            margin-top: 8px;
        }
        .tag {
            display: inline-block;
            background-color: #fee2e2;
            color: #ef4444;
            border: 1px solid #fecaca;
            font-size: 8px;
            font-weight: bold;
            padding: 2px 6px;
            margin-right: 4px;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .obese-tag {
            background-color: #ef4444;
            color: #ffffff;
            border: none;
        }
        .unit-details {
            width: 100%;
            margin-top: 15px;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }
        .unit-box {
            width: 33.33%;
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            padding: 5px;
            text-align: center;
        }
        .unit-label {
            font-size: 7px;
            font-weight: 900;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .unit-value {
            font-size: 10px;
            font-weight: 800;
            color: #334155;
            text-transform: uppercase;
        }
        .battalion-row {
            margin-top: 8px;
            font-size: 9px;
            font-weight: 800;
            color: #1e293b;
            text-transform: uppercase;
        }
        .battalion-label {
            color: #94a3b8;
            font-size: 8px;
            margin-right: 5px;
        }
        .section-title {
            background: #f8f9fa;
            padding: 12px;
            margin-bottom: 20px;
            border-left: 6px solid #ef4444;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1e293b;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="section-title">
            Improvement Registry Record Books [ইমপ্রুভমেন্ট রেজিস্ট্রি রেকর্ড বুক]
        </div>
        <table class="card-table">
            @php $count = 0; @endphp
            @foreach($soldiers as $soldier)
                @if($count % 2 == 0)
                    <tr>
                @endif
                
                <td style="width: 50%;">
                    <div class="card">
                        <table style="width: 100%;">
                            <tr>
                                <td class="photo-cell">
                                    <div class="photo">
                                        @if($soldier->photo && file_exists(public_path('storage/' . $soldier->photo)))
                                            @php
                                                $path = public_path('storage/' . $soldier->photo);
                                                $imageData = base64_encode(file_get_contents($path));
                                                $mimeType = mime_content_type($path);
                                            @endphp
                                            <img src="data:{{ $mimeType }};base64,{{ $imageData }}" style="width: 70px; height: 85px; object-fit: cover;">
                                        @else
                                            <div style="width: 70px; height: 85px; background: #f1f5f9;"></div>
                                        @endif
                                    </div>
                                </td>
                                <td class="info-cell">
                                    <div class="name">{{ $soldier->name }}</div>
                                    <div class="rank-number">{{ $soldier->rank }} • {{ $soldier->number }}</div>
                                    
                                    <div class="tags-container">
                                        @if ($soldier->ipft_biannual_1 == 'Fail' || $soldier->ipft_biannual_1 == 'Failed')
                                            <span class="tag">IPFT-1 FAIL</span>
                                        @endif
                                        @if ($soldier->ipft_biannual_2 == 'Fail' || $soldier->ipft_biannual_2 == 'Failed')
                                            <span class="tag">IPFT-2 FAIL</span>
                                        @endif

                                        @php
                                            $hasRtFail = ((int) $soldier->shoot_total < 180 && (int) $soldier->shoot_total > 0) || 
                                                        str_contains(json_encode($soldier->firing_records), '"status":"Fail"') || 
                                                        str_contains(json_encode($soldier->night_firing_records), '"status":"Fail"');
                                        @endphp
                                        @if ($hasRtFail)
                                            <span class="tag">RET FAIL</span>
                                        @endif

                                        @if ($soldier->weight_status != 'Normal' && $soldier->weight_status != 'N/A')
                                            <span class="tag {{ str_contains($soldier->weight_status, 'Obese') ? 'obese-tag' : '' }}">
                                                {{ $soldier->weight_status }}
                                            </span>
                                        @endif

                                        @if (strtolower($soldier->speed_march) == 'fail')
                                            <span class="tag">SPD MARCH FAIL</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table class="unit-details">
                            <tr>
                                <td class="unit-box">
                                    <div class="unit-label">Company</div>
                                    <div class="unit-value">{{ $soldier->company ?: '---' }}</div>
                                </td>
                                <td class="unit-box">
                                    <div class="unit-label">Platoon</div>
                                    <div class="unit-value">{{ $soldier->platoon ?: '---' }}</div>
                                </td>
                                <td class="unit-box">
                                    <div class="unit-label">Section</div>
                                    <div class="unit-value">{{ $soldier->section ?: '---' }}</div>
                                </td>
                            </tr>
                        </table>

                        <div class="battalion-row">
                            <span class="battalion-label">BATTALION</span>
                            {{ $soldier->battalion_name }}
                        </div>
                    </div>
                </td>

                @if($count % 2 == 1 || $loop->last)
                    </tr>
                @endif
                @php $count++; @endphp
            @endforeach
        </table>
    </div>
</body>
</html>
