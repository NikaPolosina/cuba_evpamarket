<?php
use Illuminate\Database\Seeder;
use App\StatusSimple;
use App\StatusOwner;
use App\Models\Role;
use App\User;
use App\UserInformation;
use App\Region;
use App\City;
use App\Company;
use App\Product;
use App\Category;
use App\DiscountAccumulativ;
use App\Group;
use App\AdditionParam;

class DatabaseSeeder extends Seeder{

    public $region        = array();
    public $city          = array();
    public $company;
    public $category      = array();
    public $additionParam = array();
    public $discount;
    public $group;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->createRegion();
        $this->createCity();
        $this->createStatusOwner();
        $this->createCompany();
        $this->createGroup();
        $this->createUserInformation();
        $this->createCategory();
        $this->createAdditionParam();
        $this->createProduct();
        $this->createDiscountAccumulative();
    }

    public function createCity(){
        $city['1'] = City::create([
            'id_cities'    => 1000095,
            'region_id'    => $this->region['1']->id_region,
            'title_cities' => '17 лет Октября'
        ]);
        $city['2'] = City::create([
            'id_cities'    => 1000096,
            'region_id'    => $this->region['1']->id_region,
            'title_cities' => 'Абадзехская'
        ]);
        $city['3'] = City::create([
            'id_cities'    => 1003245,
            'region_id'    => $this->region['2']->id_region,
            'title_cities' => 'Андреев Починок'
        ]);
        $city['4'] = City::create([
            'id_cities'    => 1001120,
            'region_id'    => $this->region['2']->id_region,
            'title_cities' => 'Большой Халуй'
        ]);
        $this->city = $city;
    }

    public function createRegion(){
        $region['1'] = Region::create([
            'title'     => 'Адыгея',
            'id_region' => 1000001,
        ]);
        $region['2'] = Region::create([
            'title'     => 'Архангельская область',
            'id_region' => 1000236,
        ]);
        $this->region = $region;
    }

    public function createStatusOwner(){
        $simpleStatus = $this->createStatusSimple();
        StatusOwner::create([
            'title'            => 'Не обработанный',
            'key'              => 'not_processed',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Уточнение деталей',
            'key'              => 'details',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        StatusOwner::create([
            'title'            => 'Звонок',
            'key'              => 'call',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Нет ответа',
            'key'              => 'no_answer',
            'status_simple_id' => $simpleStatus['1']->id
        ]);
        StatusOwner::create([
            'title'            => 'Изготовление',
            'key'              => 'making',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        StatusOwner::create([
            'title'            => 'Уточнение наличия на складе',
            'key'              => 'verification',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Доставка со склада',
            'key'              => 'delivery_warehouse',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        StatusOwner::create([
            'title'            => 'Есть в наличии',
            'key'              => 'available',
            'status_simple_id' => $simpleStatus['2']->id
        ]);
        StatusOwner::create([
            'title'            => 'Ждем оплаты',
            'key'              => 'waiting_payment',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        StatusOwner::create([
            'title'            => 'Ждем подтверждения оплаты',
            'key'              => 'waiting_confirmation_payment',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        StatusOwner::create([
            'title'            => 'Оплата прошла успешно',
            'key'              => 'payment_successful',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        $status = StatusOwner::create([
            'title'            => 'Отказ оплаты',
            'key'              => 'refusal_payment',
            'status_simple_id' => $simpleStatus['3']->id
        ]);
        StatusOwner::create([
            'title'            => 'Формирование заказа',
            'key'              => 'formation_order',
            'status_simple_id' => $simpleStatus['4']->id
        ]);
        StatusOwner::create([
            'title'            => 'Упаковка',
            'key'              => 'packaging',
            'status_simple_id' => $simpleStatus['4']->id
        ]);
        StatusOwner::create([
            'title'            => 'Отправка на промежуточный склад',
            'key'              => 'send_intermediate_storage',
            'status_simple_id' => $simpleStatus['5']->id
        ]);
        StatusOwner::create([
            'title'            => 'Отправка покупателю',
            'key'              => 'sending_buyer',
            'status_simple_id' => $simpleStatus['5']->id
        ]);
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

    public function createCompany(){
        $this->company = Company::create([
            'company_name'            => 'Платья Asos',
            'company_description'     => 'Продаем красивые наряды, которые радуют взгляд',
            'company_logo'            => '13.jpg',
            'company_content'         => 'Очень хороший магазин, у нас есть рассрочка и всё таке, любим своих клиентв, а они нас',
            'country'                 => 'Россия',
            'region_id'               => $this->region[1]->id_region,
            'city_id'                 => $this->city[1]->id_cities,
            'street'                  => 'ул. Кожедуба',
            'address'                 => '32',
            'company_contact_info'    => '+75276235476254',
            'company_additional_info' => '',
            'block'                   => 0,
        ]);
    }

    public function createCategory(){
        $this->category['1'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Одежда и обувь',
            'vip'       => 1,
            'icon'      => 'clothes',
            'img'       => 'dress',
        ]);
        $this->category['2'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Зоотовары',
            'vip'       => 1,
            'icon'      => 'animals',
            'img'       => 'zoo',
        ]);
        $this->category['3'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Косметика и парфюмерия',
            'vip'       => 1,
            'icon'      => 'perfume',
            'img'       => 'perfume',
        ]);
        $this->category['4'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Продукты питания',
            'vip'       => 1,
            'icon'      => 'food',
            'img'       => 'food',
        ]);
        $this->category['5'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Для спорта',
            'vip'       => 1,
            'icon'      => 'sport',
            'img'       => 'sport',
        ]);
        $this->category['6'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Бытовая техника',
            'vip'       => 1,
            'icon'      => 'appliances',
            'img'       => 'bit-technik',
        ]);
        $this->category['7'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Компьютеры, ноутбуки',
            'vip'       => 1,
            'icon'      => 'pc',
            'img'       => 'computers',
        ]);
        $this->category['8'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Телефоны, MP3',
            'vip'       => 1,
            'icon'      => 'phone',
            'img'       => 'telefon',
        ]);
        $this->category['9'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Транспорт',
            'vip'       => 1,
            'icon'      => 'car',
            'img'       => 'bike',
        ]);
        $this->category['10'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Товары для дома',
            'vip'       => 1,
            'icon'      => 'room',
            'img'       => 'decor',
        ]);
        $this->category['11'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Детский мир',
            'vip'       => 0,
            'icon'      => '',
            'img'       => 'children',
        ]);
        $this->category['12'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Дача, огород, сад',
            'vip'       => 0,
            'icon'      => '',
            'img'       => 'garden',
        ]);
        $this->category['13'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Электро-инструмент',
            'vip'       => 0,
            'icon'      => '',
            'img'       => 'electro',
        ]);
        $this->category['14'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Ювелирные украшения',
            'vip'       => 0,
            'icon'      => '',
            'img'       => 'jeverli',
        ]);
        $this->category['15'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Офис, школа, книги',
            'vip'       => 0,
            'icon'      => '',
            'img'       => 'book',
        ]);
        $this->category['16'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Туризм',
            'vip'       => 0,
            'icon'      => '',
            'img'       => 'turizm',
        ]);
        $this->category['17'] = Category::create([
            'parent_id' => 0,
            'title'     => 'Музыка',
            'vip'       => 0,
            'icon'      => '',
            'img'       => 'music',
        ]);
        $this->company->getCategoryCompany()->attach($this->category[1]->id);
    }

    public function createAdditionParam(){
        $this->additionParam['1'] = AdditionParam::create([
            'title'       => 'Размер',
            'key'         => 'size',
            'description' => 'Указание размера товара',
            'placeholder' => 'Выбирте размер...',
            'type'        => 'checkbox',
            'type_for_by' => 'checkbox',
            'required'    => 0,
            'sort'        => 1,
            'default'     => '',
            'request'     => 1,
            'value'       => '{"XS":{"name":"xs"},"S":{"name":"s"},"L":{"name":"l"},"XL":{"name":"xl"},"XXL":{"name":"xxl"}}',
        ]);
        $this->additionParam['2'] = AdditionParam::create([
            'title'       => 'Цвет',
            'key'         => 'color',
            'description' => 'Выбор цвета товара',
            'placeholder' => 'Выбирте цвет...',
            'type'        => 'radio',
            'type_for_by' => 'checkbox',
            'required'    => 0,
            'sort'        => 2,
            'default'     => '',
            'request'     => 1,
            'value'       => '{"red":{"name":"красный", "css":"#FF0000"}, "black":{"name":"чёрный", "css":"#000000"}, "blue":{"name":"синий", "css":"#0000FF"}, "gold":{"name":"золотой", "css":"#FFD700"}, "green" :{"name":"зелеый", "css":"#008000"}, "yellow" :{"name":"желтый", "css":	"#FFFF00"}}',
        ]);
        $this->additionParam['3'] = AdditionParam::create([
            'title'       => 'Диагонали экранов телевизоров',
            'key'         => 'inch',
            'description' => 'Диагонали экранов телевизоров (дюйм)',
            'placeholder' => 'Выбирте диагональ...',
            'type'        => 'select',
            'type_for_by' => 'checkbox',
            'required'    => 0,
            'sort'        => 1,
            'default'     => '',
            'request'     => 0,
            'value'       => '{"22":{"name":"22"},"26":{"name":"26"},"32":{"name":"32"},"37":{"name":"37"},"40":{"name":"40"},"42":{"name":"42"},"46":{"name":"46"},"50":{"name":"50"},"60":{"name":"60"},"65":{"name":"65"}}',
        ]);

        $this->additionParam['4'] = AdditionParam::create([
            'title'         => 'Произвольное поле продавца',
            'key'           => 'owner_field',
            'description'   => 'Произвольное поле покупателя',
            'placeholder'   => 'Произвольное поле продавца',
            'type'          => 'input',
            'type_for_by'   => 'input',
            'required'      => 0,
            'sort'          => 1,
            'default'       => '',
            'request'       => 0,
            'request_buyer' => 0,
            'value'         => '',
        ]);

        $this->additionParam['5'] = AdditionParam::create([
            'title'         => 'Произвольное поле покупателя',
            'key'           => 'client_field',
            'description'   => 'Произвольное поле покупателя',
            'placeholder'   => 'Произвольное поле покупателя',
            'type'          => 'input',
            'type_for_by'   => 'input',
            'required'      => 0,
            'sort'          => 1,
            'default'       => '',
            'request'       => 0,
            'request_buyer' => 1,
            'value'         => '',
        ]);
    }

    public function createProduct(){
        $this->product = Product::create([
            'product_name'        => 'Платья Синее',
            'category_id'         => $this->category[1]->id,
            'product_description' => 'отличный наряд на вечер',
            'content'             => 'В наличии размер: s, m, l; Цвет: синий',
            'product_image'       => '',
            'product_price'       => 500,
        ]);
        $this->company->getProducts()->attach($this->product);
        $this->product = Product::create([
            'product_name'        => 'Платья Красне',
            'category_id'         => $this->category[1]->id,
            'product_description' => 'длинное в пол',
            'content'             => 'В наличии размер: s, m, l; Цвет: красный насыщенный',
            'product_image'       => '',
            'product_price'       => 100,
        ]);
        $this->company->getProducts()->attach($this->product);
    }

    public function createDiscountAccumulative(){
        $this->discount = DiscountAccumulativ::create([
            'from'       => 100,
            'percent'    => 1,
            'company_id' => $this->company->id,
        ]);
        $this->discount = DiscountAccumulativ::create([
            'from'       => 500,
            'percent'    => 2,
            'company_id' => $this->company->id,
        ]);
        $this->discount = DiscountAccumulativ::create([
            'from'       => 1000,
            'percent'    => 3,
            'company_id' => $this->company->id,
        ]);
    }

    public function createGroup(){
        $this->group = Group::create([
            'company_id' => $this->company->id,
            'group_name' => 'Скидки по магазину Asos',
            'money'      => '',
        ]);
    }

    public function createUserInformation(){
        $user = $this->createUser();
        UserInformation::create([
            'user_id'    => $user[0]->id,
            'name'       => 'Админище',
            'surname'    => 'Отличный',
            'avatar'     => '',
            'date_birth' => '1990-07-12',
            'country'    => 'Россия',
            'region_id'  => $this->region['1']->id_region,
            'city_id'    => $this->city['1']->id_cities,
            'street'     => 'ул. Липовая',
            'address'    => '34',
        ]);
        UserInformation::create([
            'user_id'    => $user[1]->id,
            'name'       => 'Ника',
            'surname'    => 'Николаева',
            'avatar'     => '',
            'date_birth' => '1991-03-22',
            'country'    => 'Россия',
            'region_id'  => $this->region['1']->id_region,
            'city_id'    => $this->city['2']->id_cities,
            'street'     => 'ул. Роговца',
            'address'    => '8',
        ]);
        UserInformation::create([
            'user_id'    => $user[2]->id,
            'name'       => 'Простой1',
            'surname'    => 'Нормальный1',
            'avatar'     => '/img/users/3/avatar.png',
            'date_birth' => '1992-04-09',
            'country'    => 'Россия',
            'region_id'  => $this->region['2']->id_region,
            'city_id'    => $this->city['3']->id_cities,
            'street'     => 'ул. Парковая',
            'address'    => '12',
        ]);
        UserInformation::create([
            'user_id'    => $user[3]->id,
            'name'       => 'Простой2',
            'surname'    => 'НОрмальный2',
            'avatar'     => '/img/users/4/avatar.png',
            'date_birth' => '1986-01-12',
            'country'    => 'Россия',
            'region_id'  => $this->region['2']->id_region,
            'city_id'    => $this->city['4']->id_cities,
            'street'     => 'ул. Гаупа',
            'address'    => '6',
        ]);
    }

    public function createUser(){
        $role = $this->createRole();
        $data = array();
        $user = User::create([
            'email'    => 'admin@admin.com',
            'phone'    => '11111111111',
            'active'   => 1,
            'block'    => 0,
            'password' => bcrypt(123456),
        ]);
        $user->attachRole($role['admin']);
        $data[] = $user;
        $user = User::create([
            'email'    => 'nika@nika.com',
            'phone'    => '222222222',
            'active'   => 1,
            'block'    => 0,
            'password' => bcrypt(123456),
        ]);
        $user->attachRole($role['company_owner']);
        $this->company->getUser()->attach($user);
        $data[] = $user;
        $user = User::create([
            'email'    => 'simple1@simple1.com',
            'phone'    => '33333333333',
            'active'   => 1,
            'block'    => 0,
            'password' => bcrypt(123456),
        ]);
        $user->attachRole($role['simple_user']);
        $this->group->getUser()->attach($user, [ 'is_admin' => 1 ]);
        $data[] = $user;
        $user = User::create([
            'email'    => 'simple2@simple2.com',
            'phone'    => '44444444444444444',
            'active'   => 1,
            'block'    => 0,
            'password' => bcrypt(123456),
        ]);
        $user->attachRole($role['simple_user']);
        $data[] = $user;
        return $data;
    }

    public function createRole(){
        $role['admin'] = Role::create([
            'name'         => 'admin',
            'display_name' => 'Admin',
            'description'  => 'Administratir site'
        ]);
        $role['simple_user'] = Role::create([
            'name'         => 'simple_user',
            'display_name' => 'Simple User',
            'description'  => 'User is simple user'
        ]);
        $role['company_owner'] = Role::create([
            'name'         => 'company_owner',
            'display_name' => 'Company Owner',
            'description'  => 'User is the owner of a company'
        ]);
        return $role;
    }
}
