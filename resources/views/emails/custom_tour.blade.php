<div class="maincont">
    <div class="container">
        <p>Tour Name: {{$model->tour_name_en}}</p>
        <p>Tour Url: <a href="{{url('/tours/' . $model->tour_url)}}">{{url('/tours/' . $model->tour_url)}}</a></p>
    </div>
</div>