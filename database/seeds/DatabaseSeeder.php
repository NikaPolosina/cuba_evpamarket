<?php
use Illuminate\Database\Seeder;
use App\StatusSimple;
use App\StatusOwner;
use App\Models\Role;

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

            'title'            => 'Не обработанный',
            'key'              => 'not_processed',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        $status = StatusOwner::create([

            'title'            => 'Уточнение деталей',
            'key'              => 'details',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Звонок',
            'key'              => 'call',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Нет ответа',
            'key'              => 'no_answer',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Изготовление',
            'key'              => 'making',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Уточнение наличия на складе',
            'key'              => 'verification',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Доставка со склада',
            'key'              => 'delivery_warehouse',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Есть в наличии',
            'key'              => 'available',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Ждем оплаты',
            'key'              => 'waiting_payment',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Ждем подтверждения оплаты',
            'key'              => 'waiting_confirmation_payment',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Оплата прошла успешно',
            'key'              => 'payment_successful',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Отказ оплаты',
            'key'              => 'refusal_payment',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Формирование заказа',
            'key'              => 'formation_order',
            'status_simple_id' => $simpleStatus['4']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Упаковка',
            'key'              => 'packaging',
            'status_simple_id' => $simpleStatus['4']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Отправка на промежуточный склад',
            'key'              => 'send_intermediate_storage',
            'status_simple_id' => $simpleStatus['5']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Отправка покупателю',
            'key'              => 'sending_buyer',
            'status_simple_id' => $simpleStatus['5']->id
        ]);

    }
    
    public function createRole(){
        $role = Role::create([
            'name'            => 'admin',
            'display_name'    => 'Admin',
            'description'    => 'Administratir site'
        ]);
        $role = Role::create([
            'name'            => 'simple_user',
            'display_name'    => 'Simple User',
            'description'    => 'User is simple user'
        ]);
        $role = Role::create([
            'name'            => 'company_owner',
            'display_name'    => 'Company Owner',
            'description'    => 'User is the owner of a company'
        ]);

    }
}
