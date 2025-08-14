<x-mail::table>
| Поле | Значение |
| :--- | :------- |
@if (! empty($form->recordable->service))
| Услуга | {{ $form->recordable->service->title }} |
@endif
| Имя | {{ $form->recordable->name }} |
| Телефон | {{ $form->recordable->phone }} |
| Комментарий | {{ $form->recordable->comment }} |
@if (! empty($form->uri))
| Страница | [Перейти]({{ $form->uri }}) |
@endif
@if (! empty($item->place))
| Кнопка | {{ $form->palce }} |
@endif
</x-mail::table>
