<x-mail::table>
| Поле | Значение |
| :--- | :------- |
| Имя | {{ $form->recordable->name }} |
| Телефон | {{ $form->recordable->phone }} |
@if (! empty($form->uri))
| Страница | [Перейти]({{ $form->uri }}) |
@endif
@if (! empty($item->place))
| Кнопка | {{ $form->palce }} |
@endif
</x-mail::table>
