<div>
    <p>Hörmətli <b>{{$email}}</b></p>
    <p>Məlumatınız olsun ki, <b>{{$meet_creator}}</b>, {{$meet_date}} il tarixi üçün, {{$meet_start_time}} - {{$meet_end_time}} -dək {{$meet_room_name}} iclas otağını aşağıdakı şəxslərin iştirakı üçün rezerv etmişdir:</p>
    @if($meet_title)
    <p>Görüşün başlığı: <b>{{$meet_title}}</b> </p>
    @endif
    @if(count($emails) > 0)
    <p>İştirakçılar:</p>
    <ul>
        @foreach($emails as $key => $email)
            <li>{{$key+1}}. {{$email}}</li>
        @endforeach
    </ul>
    @endif
    <p>Hörmətlə,</p>
    <p>{{ config('app.name') }}</p>
</div>
