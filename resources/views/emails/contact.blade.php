@component('mail::message')
De volgende gegevens zijn achtergelaten via het contactformulier:
## Gegevens
@component('mail::table', ['class' => 'no-th'])
|                          |                      |
| ------------------------ | -------------------- |
| **Voor- en achternaam:** | {{ $post['name'] }}  |
| **Telefoonnummer:**      | {{ $post['phone'] }} |
| **E-mailadres:**         | {{ $post['email'] }} |
@endcomponent

**Bericht**
@component('mail::panel')
{!! nl2br(e(strip_tags($post['comments']))) !!}
@endcomponent
@endcomponent