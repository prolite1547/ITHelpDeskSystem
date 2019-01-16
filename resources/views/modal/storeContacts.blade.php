<div class="store-contact">
    <h2 class="store-contact__header">{{$store->store_name}}</h2>
    <ul class="store-contact__list">
        @foreach($store->contacts as $contact)
            <li class="store-contact__item">{{$contact->number}}</li>
        @endforeach
    </ul>
</div>
