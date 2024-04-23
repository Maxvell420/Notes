<x-content :title="$title">
    <div class="form">
        <h2>Создание обьявления</h2>
        <form action="{{route('house.confirm')}}" method="post">
            @csrf
            <h3>Основная Информация</h3>
            <x-house.crud.mainInfo/>
            <h3>Дополнительная информация</h3>
            <x-house.crud.additionInfo/>
            <button type="submit" class="navButton">Создать</button>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</x-content>
