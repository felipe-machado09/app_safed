@component('mail::message')
    <h2>Olá {{ $user->name }},</h2>
    <h3>Clique no botão abaixo para realizar o download do relatório solicitado.</h3>
    @component('mail::button', [
    'url' =>  'http://localhost:8000/download/file/'.$file->name.'?token=106c0939-9d67-4928-a909-27fdbf4d65be'
    ])
    Download
    @endcomponent

    Este download ficará disponivel por 3 dias após isto ele sera apagado do servidor!
@endcomponent

