<?php
use Illuminate\Database\Seeder;
use App\StatusSimple;
use App\StatusOwner;

class DatabaseSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->createStatusOwner();
    }

    public function createStatusSimple(){
        $status = array();
        $status['1'] = StatusSimple::create([
            'title' => 'Уточнение',
        ]);
        $status['2'] = StatusSimple::create([
            'title' => 'Обработка',
        ]);
        $status['3'] = StatusSimple::create([
            'title' => 'Ждет оплаты',
        ]);
        $status['4'] = StatusSimple::create([
            'title' => 'Формирование',
        ]);
        $status['5'] = StatusSimple::create([
            'title' => 'Отправлен',
        ]);
        return $status;
    }

    public function createStatusOwner(){
        $simpleStatus = $this->createStatusSimple();
        $status = StatusOwner::create([
            'title'            => 'Уточнение деталей',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Звонок',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Нет ответа',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Изготовление',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Уточнение наличия на складе',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Доставка со склада',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Есть в наличии',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Ждем оплаты',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Ждем подтверждения оплаты',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Оплата прошла успешно',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Отказ оплаты',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Формирование заказа',
            'status_simple_id' => $simpleStatus['4']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Упаковка',
            'status_simple_id' => $simpleStatus['4']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Отправка на промежуточный склад',
            'status_simple_id' => $simpleStatus['5']->id
        ]);
        $status = StatusOwner::create([
            'title' => 'Отправка покупателю',
            'status_simple_id' => $simpleStatus['5']->id
        ]);

    }
}
