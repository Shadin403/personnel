<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: 'nikosh', sans-serif; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 15px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 2px; }
        .header p { margin: 5px 0 0; font-size: 14px; font-weight: bold; color: #666; }
        
        .section-title { 
            background: #f8f9fa; 
            padding: 10px; 
            margin-top: 25px; 
            margin-bottom: 10px; 
            border-left: 5px solid #dc3545; 
            font-size: 16px; 
            font-weight: bold; 
            text-transform: uppercase;
            color: #333;
        }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; }
        th, td { border: 1px solid #000; padding: 6px 4px; text-align: center; }
        th { background: #eeeeee; font-weight: bold; text-transform: uppercase; }
        
        .name-cell { text-align: left; font-weight: bold; }
        .status-fail { color: #dc3545; font-weight: bold; }
        
        .page-break { page-break-after: always; }
        .no-records { padding: 20px; text-align: center; color: #999; font-style: italic; border: 1px dashed #ccc; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Improvement Registry Nominal Roll</h1>
        <p>Strategic Personnel Remediation List - {{ now()->format('d M Y') }}</p>
    </div>

    {{-- 1. IPFT FAIL Nominal Roll --}}
    @if($category === 'all' || $category === 'IP50')
    <div class="section-title">IPFT Fail Nominal Roll [আইপিএফটি ফেল তালিকা]</div>
    @if($ipft_fails->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">Sl</th>
                    <th style="width: 80px;">No.</th>
                    <th style="width: 80px;">Rank</th>
                    <th>Name</th>
                    <th>Unit/Sub-Unit</th>
                    <th>IPFT-1</th>
                    <th>IPFT-2</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ipft_fails as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s->number }}</td>
                        <td>{{ $s->rank }}</td>
                        <td class="name-cell">{{ $s->name }}</td>
                        <td>{{ $s->company }} / {{ $s->platoon }}</td>
                        <td class="{{ in_array(strtoupper($s->ipft_biannual_1), ['FAIL', 'FAILED', 'F']) ? 'status-fail' : '' }}">
                            {{ $s->ipft_biannual_1 }}
                        </td>
                        <td class="{{ in_array(strtoupper($s->ipft_biannual_2), ['FAIL', 'FAILED', 'F']) ? 'status-fail' : '' }}">
                            {{ $s->ipft_biannual_2 }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-records">No personnel found in this category.</div>
    @endif
    @endif

    {{-- 2. RET FAIL Nominal Roll --}}
    @if($category === 'all' || $category === 'RT')
    <div class="section-title">RET Fail Nominal Roll [আরইটি ফেল তালিকা]</div>
    @if($ret_fails->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">Sl</th>
                    <th style="width: 80px;">No.</th>
                    <th style="width: 80px;">Rank</th>
                    <th>Name</th>
                    <th>Unit/Sub-Unit</th>
                    <th>Marks</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $sl = 1; @endphp
                @foreach($ret_fails as $s)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $s->number }}</td>
                        <td>{{ $s->rank }}</td>
                        <td class="name-cell">{{ $s->name }}</td>
                        <td>{{ $s->company }} / {{ $s->platoon }}</td>
                        <td>{{ $s->shoot_total }}</td>
                        <td class="status-fail">FAIL</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-records">No personnel found in this category.</div>
    @endif
    @endif

    {{-- 3. Overweight Nominal Roll --}}
    @if($category === 'all' || $category === 'Overweight')
    <div class="section-title">Overweight Nominal Roll [অতিরিক্ত ওজন তালিকা]</div>
    @if($overweight_fails->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">Sl</th>
                    <th style="width: 80px;">No.</th>
                    <th style="width: 80px;">Rank</th>
                    <th>Name</th>
                    <th style="width: 60px;">Weight</th>
                    <th style="width: 60px;">Standard</th>
                    <th style="width: 60px;">Extra</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $sl = 1; @endphp
                @foreach($overweight_fails as $s)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $s->number }}</td>
                        <td>{{ $s->rank }}</td>
                        <td class="name-cell">{{ $s->name }}</td>
                        <td>{{ $s->weight }}</td>
                        <td>{{ number_format($s->standard_weight, 1) }}</td>
                        <td class="{{ ($s->weight - $s->standard_weight) > 0 ? 'status-fail' : '' }}">
                            {{ number_format(max(0, $s->weight - $s->standard_weight), 1) }}
                        </td>
                        <td class="status-fail">{{ $s->weight_status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-records">No personnel found in this category.</div>
    @endif
    @endif

    <div style="margin-top: 50px; text-align: right;">
        <div style="display: inline-block; border-top: 1px solid #000; padding: 5px 30px; font-weight: bold; font-size: 12px;">
            Authorized Command Signature
        </div>
    </div>
</body>
</html>
