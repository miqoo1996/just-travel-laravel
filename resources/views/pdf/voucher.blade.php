{{--{{dd($order)}}--}}
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Generate PDF</title>
    {{--<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">--}}
    <style>
        @font-face {
            font-family: 'Roboto';
            src('/fonts/Roboto/Roboto-Regular.ttf')) format('truetype')
        }
        @page { margin: 0px; }
        body { margin: 0px; }
        .pdf-body{ background:#F1F1F1; margin:0px;font-family: 'Roboto', sans-serif;}
        .pdf-generator{height:842px; background:#FFF; box-shadow:0 0 5px #CCC; position:relative;}
        .pdf-generator .pdf-header{ height:80px; background:#F1F1F1 url({{asset('images/pdf_logo.png')}}) center center no-repeat; background-size:60px; line-height:1.2; font-size:15px;}
        .pdf-generator .header-l{ float:left; margin:22px 0 0 20px;}
        .pdf-generator .header-r{ float:right; margin:22px 20px 0 0; text-align:right;}
        .pdf-generator h1{ margin:30px 0; text-align:center; font-size:24px;}
        .pdf-generator .tourdate{margin:0 0 30px; text-align:center;}
        .pdf-generator .info-container{ display:inline-block; float:left; width:50%; padding:30px; box-sizing:border-box; font-size:14px;}
        .pdf-generator .description{padding:0 30px; font-size:14px; line-height:1.5; color:#666;}
        .pdf-generator h2{ font-size:20px; text-align:center;border-bottom:solid 1px #CCC; padding:0 0 10px;}
        .pdf-generator .info-container .date{ float:right; color:#666;}
        .pdf-generator .info-container .value{ float:right; color:#000; font-weight:700;}
        .pdf-generator .info-container div{padding:3px 0;}
        .pdf-footer{ position:absolute; bottom:0px; left:0px; right:0px; padding:15px; font-size:12px; text-align:center;color:#666;}
        .qr-code{ position:absolute; width:100px; height:100px; bottom:60px; margin:0 0 0 -50px; left:50%;}
        .qr-code img{ width:100%;}
    </style>
</head>

<body class="pdf-body">

<div class="pdf-generator">
    <div class="pdf-header">
        <div class="header-l">
            {{trans('messages.tour_lang')}}: <b>{{trans('messages.cur_lang')}}</b><br />
            {{trans('messages.order_date')}}: <b>{{date('d.m.Y')}}</b>
        </div>
        <div class="header-r">
            {{trans('messages.tour_id')}}: <b>{{$order['tour']['code']}}</b><br />
            {{trans('messages.order_id')}}: <b>{{$order['order_id']}}</b>
        </div>
    </div>
    <h1>{{$order['tour']['tour_name_'.app()->getLocale()]}}</h1>
    <div class="tourdate">{{str_replace('/', '.',$order['date_from'])}}</div>
    <div class="description">{!! $order['tour']['desc_en'] !!}</div>
    <div class="info-container">
        <h2>{{trans('messages.travelers')}}</h2>
        @foreach($order['members'] as $member)
            <div><span class="date">{{str_replace('/', '.',$order['date_from'])}}</span>{{$member['member_name'] . ' ' . $member['member_surname']}}</div>
        @endforeach
    </div>
    <div class="info-container">
        <h2>{{trans('messages.details')}}</h2>
        <div><span class="value">{{count($order['members'])}}</span>{{trans('messages.total_travelers')}}</div>
        <div><span class="value {{$currency['currency']}}">{{2440}}</span>Total Price</div>
    </div>
    <div class="qr-code"><img src="{{asset('images/qr/' . $order->id . '_qrcode.png')}}" alt=""></div>
    <div class="pdf-footer">+374 55 007 404  /  +374 95 111 610  /  info@justtravel.am</div>
</div>
</body>
</html>
