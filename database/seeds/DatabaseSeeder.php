<?php
use Illuminate\Database\Seeder;
use App\StatusSimple;
use App\StatusOwner;
use App\Models\Role;
use App\User;
use App\UserInformation;

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


    public function createUser(){
        $role = $this->createRole();
        DB::table('users')->delete();

        $user = User::create([
            'id'               => 1,
            'email'            => 'admin@admin.com',
            'phone'            => '11111111111',
            'active'           => 1,
            'block'            => 0,
            'password'         => bcrypt(123456),

        ]);
        $user->attachRole($role['admin']);

        $user = User::create([
            'id'               => 2,
            'email'            => 'nika@nika.com',
            'phone'            => '222222222',
            'active'           => 1,
            'block'            => 0,
            'password'         => bcrypt(123456),
        ]);
        $user->attachRole($role['company_owner']);

        $user = User::create([
            'id'               => 3,
            'email'            => 'simple1@simple1.com',
            'phone'            => '33333333333',
            'active'           => 1,
            'block'            => 0,
            'password'         => bcrypt(123456),
        ]);
        $user->attachRole($role['simple_user']);

        $user = User::create([
            'id'               => 4,
            'email'            => 'simple2@simple2.com',
            'phone'            => '44444444444444444',
            'active'           => 1,
            'block'            => 0,
            'password'         => bcrypt(123456),
        ]);
        $user->attachRole($role['simple_user']);

    }
    public function createUserInformation(){
        $user = $this->createUser();
        $user = UserInformation::create([
            'id'               => 1,
            'user_id'          => $user->id,
            'name'            => 'Админище',
            'surname'           => 'Отличный',
            'avatar'            => '',
            'date_birth'         => '1990-07-12',
            'country'         => 'Россия',
            'region_id'         => '257',
            'city_id'         => '47661',
            'street'         => 'ул. Липовая',
            'address'         => '34',
        ]);
        $user = UserInformation::create([
            'id'               => 2,
            'user_id'          => $user->id,
            'name'            => 'Ника',
            'surname'           => 'Николаева',
            'avatar'            => '',
            'date_birth'         => '1991-03-22',
            'country'         => 'Россия',
            'region_id'         => '257',
            'city_id'         => '47661',
            'street'         => 'ул. Роговца',
            'address'         => '8',
        ]);
        $user = UserInformation::create([
            'id'               => 3,
            'user_id'          => $user->id,
            'name'            => 'Простой1',
            'surname'           => 'Нормальный1',
            'avatar'            => '',
            'date_birth'         => '1992-04-09',
            'country'         => 'Россия',
            'region_id'         => '257',
            'city_id'         => '47661',
            'street'         => 'ул. Парковая',
            'address'         => '12',
        ]);
        $user = UserInformation::create([
            'id'               => 4,
            'user_id'          => $user->id,
            'name'            => 'Простой2',
            'surname'           => 'НОрмальный2',
            'avatar'            => '',
            'date_birth'         => '1986-01-12',
            'country'         => 'Россия',
            'region_id'         => '257',
            'city_id'         => '47661',
            'street'         => 'ул. Гаупа',
            'address'         => '6',
        ]);

    }



    public function createRole(){
        $role = Role::create([
            'name'         => 'admin',
            'display_name' => 'Admin',
            'description'  => 'Administratir site'
        ]);
        $role = Role::create([
            'name'         => 'simple_user',
            'display_name' => 'Simple User',
            'description'  => 'User is simple user'
        ]);
        $role = Role::create([
            'name'         => 'company_owner',
            'display_name' => 'Company Owner',
            'description'  => 'User is the owner of a company'
        ]);
    }

}
