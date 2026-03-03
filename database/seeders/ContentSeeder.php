<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Box;
use App\Models\Campaign;
use App\Models\HomeAbout;
use App\Models\HomeCta;
use App\Models\HomeWhyUs;
use App\Models\Partner;
use App\Models\PortfolioItem;
use App\Models\PrivacyPage;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('blog_post_blog_tag')->truncate();
        BlogTag::truncate();
        BlogPost::truncate();
        PortfolioItem::truncate();
        Service::truncate();
        Box::truncate();
        Campaign::truncate();
        Testimonial::truncate();
        Partner::truncate();
        Slider::truncate();
        HomeAbout::truncate();
        HomeCta::truncate();
        HomeWhyUs::truncate();
        PrivacyPage::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // --- Sliders ---
        Slider::create([
            'title'       => ['az' => 'Peşəkar Usta Xidmətləri', 'en' => 'Professional Handyman Services', 'ru' => 'Профессиональные услуги мастера'],
            'subtitle'    => ['az' => 'Bakıda etibarlı, sürətli və keyfiyyətli ev təmir xidmətləri', 'en' => 'Reliable, fast and quality home repair services in Baku', 'ru' => 'Надёжные, быстрые и качественные услуги по ремонту дома в Баку'],
            'button_text' => ['az' => 'Sifariş et', 'en' => 'Order now', 'ru' => 'Заказать'],
            'button_url'  => '/az/elaqe',
            'image'       => '',
            'order'       => 1,
            'is_active'   => true,
        ]);
        Slider::create([
            'title'       => ['az' => 'Mebel Quraşdırılması', 'en' => 'Furniture Assembly', 'ru' => 'Сборка мебели'],
            'subtitle'    => ['az' => 'İKEA, HOFF və digər brendlər üzrə peşəkar montaj', 'en' => 'Professional assembly for IKEA, HOFF and other brands', 'ru' => 'Профессиональная сборка IKEA, HOFF и других брендов'],
            'button_text' => ['az' => 'Ətraflı', 'en' => 'Learn more', 'ru' => 'Подробнее'],
            'button_url'  => '/az/xidmetler',
            'image'       => '',
            'order'       => 2,
            'is_active'   => true,
        ]);

        // --- Services ---
        $svc1 = Service::create([
            'title'             => ['az' => 'Mebel Quraşdırılması', 'en' => 'Furniture Assembly', 'ru' => 'Сборка мебели'],
            'slug'              => ['az' => 'mebel-qurasdirilmasi', 'en' => 'furniture-assembly', 'ru' => 'sborka-mebeli'],
            'short_description' => ['az' => 'Hər növ mebelin peşəkar quraşdırılması. İKEA, HOFF, BRW ustası.', 'en' => 'Professional assembly of all types of furniture. IKEA, HOFF, BRW specialist.', 'ru' => 'Профессиональная сборка мебели всех видов. Специалист IKEA, HOFF, BRW.'],
            'content'           => ['az' => '<p>166 Usta olaraq hər növ mebelin quraşdırılmasını peşəkar şəkildə həyata keçiririk. Müştərilərimizin vaxtını dəyərli saydığımız üçün mebeli sürətli, dəqiq və zərərsiz şəkildə qururuq.</p>', 'en' => '<p>At 166 Usta, we professionally assemble all types of furniture. We value our customers\' time, so we assemble furniture quickly, accurately and safely.</p>', 'ru' => '<p>В 166 Уста мы профессионально собираем мебель всех видов. Мы ценим время наших клиентов, поэтому работаем быстро, точно и аккуратно.</p>'],
            'advantages'        => [
                'az' => ['Sürətli quraşdırma', 'Zəmanətli iş', 'Əlverişli qiymət', 'Təcrübəli ustalar'],
                'en' => ['Fast assembly', 'Guaranteed work', 'Affordable price', 'Experienced craftsmen'],
                'ru' => ['Быстрая сборка', 'Гарантированная работа', 'Доступные цены', 'Опытные мастера'],
            ],
            'steps_title'    => ['az' => 'Necə işləyirik?', 'en' => 'How do we work?', 'ru' => 'Как мы работаем?'],
            'steps_subtitle' => ['az' => 'Sadə addımlarla peşəkar xidmət', 'en' => 'Professional service in simple steps', 'ru' => 'Профессиональный сервис в простых шагах'],
            'steps'          => [
                ['image' => null, 'title' => ['az' => 'Zəng edin', 'en' => 'Call us', 'ru' => 'Позвоните нам'], 'description' => ['az' => 'Bizimlə əlaqə saxlayın', 'en' => 'Contact us', 'ru' => 'Свяжитесь с нами']],
                ['image' => null, 'title' => ['az' => 'Usta gəlir', 'en' => 'Craftsman arrives', 'ru' => 'Мастер прибывает'], 'description' => ['az' => 'Təcrübəli ustamız sizin yanınıza gəlir', 'en' => 'Our experienced craftsman comes to you', 'ru' => 'Наш мастер приезжает к вам']],
                ['image' => null, 'title' => ['az' => 'İş tamamlanır', 'en' => 'Work completed', 'ru' => 'Работа завершена'], 'description' => ['az' => 'Keyfiyyətli iş görülür, zibil götürülür', 'en' => 'Quality work done, debris removed', 'ru' => 'Работа выполнена, мусор убран']],
            ],
            'meta_title'       => ['az' => 'Mebel Quraşdırılması Bakıda | 166 Usta', 'en' => 'Furniture Assembly in Baku | 166 Usta', 'ru' => 'Сборка мебели в Баку | 166 Уста'],
            'meta_description' => ['az' => 'Bakıda peşəkar mebel quraşdırılması. İKEA, HOFF, BRW ustası. Sürətli, keyfiyyətli.', 'en' => 'Professional furniture assembly in Baku. IKEA, HOFF, BRW specialist. Fast, quality.', 'ru' => 'Профессиональная сборка мебели в Баку. Быстро, качественно.'],
            'order' => 1, 'is_active' => true, 'show_in_menu' => true,
        ]);

        $svc2 = Service::create([
            'title'             => ['az' => 'Santexnik Xidmətlər', 'en' => 'Plumbing Services', 'ru' => 'Сантехнические услуги'],
            'slug'              => ['az' => 'santexnik-xidmetler', 'en' => 'plumbing-services', 'ru' => 'santekhnicheskiye-uslugi'],
            'short_description' => ['az' => 'Boru sızmaları, kran dəyişimi, drenaj — bütün santexnik işlər 7/24.', 'en' => 'Pipe leaks, faucet replacement, drainage — all plumbing services 24/7.', 'ru' => 'Протечки, замена кранов, канализация — все сантехнические работы 24/7.'],
            'content'           => ['az' => '<p>Santexnik problemlər gözlənilməz vaxtda ortaya çıxa bilər. 166 Usta-nın santexnik komandası 7/24 xidmətinizdədir. Sürətli müdaxilə, keyfiyyətli iş zəmanəti.</p>', 'en' => '<p>Plumbing problems can arise unexpectedly. 166 Usta\'s plumbing team is at your service 24/7. Fast response, quality work guaranteed.</p>', 'ru' => '<p>Сантехнические проблемы могут возникнуть неожиданно. Бригада 166 Уста к вашим услугам 24/7. Быстрый выезд, гарантия качества.</p>'],
            'advantages'        => [
                'az' => ['7/24 xidmət', 'Sürətli müdaxilə', 'Orijinal materiallar', 'Zəmanət'],
                'en' => ['24/7 service', 'Fast response', 'Original materials', 'Warranty'],
                'ru' => ['Сервис 24/7', 'Быстрый выезд', 'Оригинальные материалы', 'Гарантия'],
            ],
            'steps_title'    => ['az' => 'Xidmət prosesi', 'en' => 'Service process', 'ru' => 'Процесс обслуживания'],
            'steps_subtitle' => null,
            'steps'          => [
                ['image' => null, 'title' => ['az' => 'Müraciət', 'en' => 'Apply', 'ru' => 'Обращение'], 'description' => ['az' => 'Zəng edin və ya WhatsApp yazın', 'en' => 'Call or write on WhatsApp', 'ru' => 'Позвоните или напишите в WhatsApp']],
                ['image' => null, 'title' => ['az' => 'Usta gəlir', 'en' => 'Craftsman arrives', 'ru' => 'Мастер прибывает'], 'description' => ['az' => '30-60 dəqiqə ərzində ustamız yanınızdadır', 'en' => 'Our craftsman is with you within 30-60 min', 'ru' => 'Наш мастер у вас в течение 30-60 мин']],
                ['image' => null, 'title' => ['az' => 'Problem həll olunur', 'en' => 'Problem solved', 'ru' => 'Проблема решена'], 'description' => ['az' => 'Keyfiyyətli iş, təmiz yer', 'en' => 'Quality work, clean place', 'ru' => 'Качественная работа, чистое место']],
            ],
            'meta_title'       => ['az' => 'Santexnik Xidmətlər Bakıda | 166 Usta', 'en' => 'Plumbing Services in Baku | 166 Usta', 'ru' => 'Сантехника в Баку | 166 Уста'],
            'meta_description' => ['az' => '7/24 Bakıda santexnik xidməti. Boru sızması, kran, drenaj. Peşəkar ustalar.', 'en' => '24/7 plumbing in Baku. Pipe leaks, faucet, drainage. Professional craftsmen.', 'ru' => 'Сантехника 24/7 в Баку. Течи, краны, канализация. Профессиональные мастера.'],
            'order' => 2, 'is_active' => true, 'show_in_menu' => true,
        ]);

        $svc3 = Service::create([
            'title'             => ['az' => 'Elektrik İşləri', 'en' => 'Electrical Work', 'ru' => 'Электромонтаж'],
            'slug'              => ['az' => 'elektrik-isleri', 'en' => 'electrical-work', 'ru' => 'elektromontazh'],
            'short_description' => ['az' => 'Elektrik paneli, kabel, rozetka, açar dəyişimi. Sertifikatlı ustalar, 1 il zəmanət.', 'en' => 'Electrical panel, cable, socket, switch replacement. Certified craftsmen, 1 year warranty.', 'ru' => 'Щиток, кабель, розетки, выключатели. Сертифицированные мастера, гарантия 1 год.'],
            'content'           => ['az' => '<p>Elektrik işlərinin peşəkar əllərə həvalə edilməsi həm təhlükəsizlik, həm də etibarlılıq baxımından vacibdir. Sertifikatlı elektrik ustalarımız bütün növ elektrik işlərini həyata keçirir.</p>', 'en' => '<p>Entrusting electrical work to professionals is important for both safety and reliability. Our certified electricians carry out all types of electrical work.</p>', 'ru' => '<p>Доверять электроработы профессионалам важно для безопасности и надёжности. Наши сертифицированные электрики выполняют все виды электромонтажных работ.</p>'],
            'advantages'        => [
                'az' => ['Sertifikatlı ustalar', 'Təhlükəsiz iş', 'Keyfiyyətli material', '1 il zəmanət'],
                'en' => ['Certified craftsmen', 'Safe work', 'Quality materials', '1 year warranty'],
                'ru' => ['Сертифицированные мастера', 'Безопасная работа', 'Качественные материалы', 'Гарантия 1 год'],
            ],
            'steps_title'    => ['az' => 'İş mərhələləri', 'en' => 'Work stages', 'ru' => 'Этапы работы'],
            'steps_subtitle' => null,
            'steps'          => [
                ['image' => null, 'title' => ['az' => 'Baxış', 'en' => 'Inspection', 'ru' => 'Осмотр'], 'description' => ['az' => 'Sistemin vəziyyəti qiymətləndirilir', 'en' => 'System condition is evaluated', 'ru' => 'Оценивается состояние системы']],
                ['image' => null, 'title' => ['az' => 'Montaj', 'en' => 'Installation', 'ru' => 'Монтаж'], 'description' => ['az' => 'Peşəkar montaj işləri aparılır', 'en' => 'Professional installation is carried out', 'ru' => 'Выполняются профессиональные монтажные работы']],
                ['image' => null, 'title' => ['az' => 'Yoxlama', 'en' => 'Testing', 'ru' => 'Проверка'], 'description' => ['az' => 'Sistem test edilib müştəriyə verilir', 'en' => 'System is tested and handed over', 'ru' => 'Система проверяется и передаётся клиенту']],
            ],
            'meta_title'       => ['az' => 'Elektrik İşləri Bakıda | 166 Usta', 'en' => 'Electrical Work in Baku | 166 Usta', 'ru' => 'Электромонтаж в Баку | 166 Уста'],
            'meta_description' => ['az' => 'Peşəkar elektrik işləri Bakıda. Sertifikatlı ustalar, 1 il zəmanət.', 'en' => 'Professional electrical work in Baku. Certified craftsmen, 1 year warranty.', 'ru' => 'Профессиональный электромонтаж в Баку. Гарантия 1 год.'],
            'order' => 3, 'is_active' => true, 'show_in_menu' => true,
        ]);

        $svc4 = Service::create([
            'title'             => ['az' => 'Kondisioner Quraşdırılması', 'en' => 'AC Installation', 'ru' => 'Установка кондиционера'],
            'slug'              => ['az' => 'kondisioner-qurasdirilmasi', 'en' => 'ac-installation', 'ru' => 'ustanovka-konditsionera'],
            'short_description' => ['az' => 'Kondisioner quraşdırılması, sökülməsi, texniki xidməti. Bütün markalar, 2 il zəmanət.', 'en' => 'AC installation, dismantling, maintenance. All brands, 2 year warranty.', 'ru' => 'Установка, демонтаж, обслуживание кондиционеров. Все бренды, гарантия 2 года.'],
            'content'           => ['az' => '<p>Kondisioner quraşdırılması xüsusi bilik tələb edir. Sertifikatlı ustalarımız Samsung, LG, Midea, Daikin, Gree kondisionerlərini quraşdırır.</p>', 'en' => '<p>AC installation requires special knowledge. Our certified technicians install Samsung, LG, Midea, Daikin, Gree air conditioners.</p>', 'ru' => '<p>Установка кондиционера требует специальных знаний. Наши сертифицированные специалисты устанавливают Samsung, LG, Midea, Daikin, Gree.</p>'],
            'advantages'        => [
                'az' => ['Bütün markalar', 'Divar deşilməsi', 'Qaz doldurulması', '2 il zəmanət'],
                'en' => ['All brands', 'Wall drilling', 'Gas refilling', '2 year warranty'],
                'ru' => ['Все бренды', 'Сверление стен', 'Заправка газом', 'Гарантия 2 года'],
            ],
            'steps_title'    => ['az' => 'Quraşdırma prosesi', 'en' => 'Installation process', 'ru' => 'Процесс установки'],
            'steps_subtitle' => null,
            'steps'          => [
                ['image' => null, 'title' => ['az' => 'Yer seçimi', 'en' => 'Location selection', 'ru' => 'Выбор места'], 'description' => ['az' => 'Optimal quraşdırma yeri müəyyən edilir', 'en' => 'Optimal location is determined', 'ru' => 'Определяется оптимальное место']],
                ['image' => null, 'title' => ['az' => 'Montaj', 'en' => 'Mounting', 'ru' => 'Монтаж'], 'description' => ['az' => 'Daxili və xarici blok quraşdırılır', 'en' => 'Indoor and outdoor unit installed', 'ru' => 'Устанавливаются внутренний и внешний блоки']],
                ['image' => null, 'title' => ['az' => 'Test', 'en' => 'Test', 'ru' => 'Тест'], 'description' => ['az' => 'Sistem yoxlanılır, müştəriyə verilir', 'en' => 'System tested and handed over', 'ru' => 'Система проверяется и передаётся']],
            ],
            'meta_title'       => ['az' => 'Kondisioner Quraşdırılması | 166 Usta', 'en' => 'AC Installation in Baku | 166 Usta', 'ru' => 'Установка кондиционера в Баку | 166 Уста'],
            'meta_description' => ['az' => 'Kondisioner quraşdırılması Bakıda. Samsung, LG, Midea. Sertifikatlı ustalar.', 'en' => 'AC installation in Baku. Samsung, LG, Midea. Certified technicians.', 'ru' => 'Установка кондиционера в Баку. Samsung, LG, Midea. Гарантия 2 года.'],
            'order' => 4, 'is_active' => true, 'show_in_menu' => true,
        ]);

        // --- Home About ---
        HomeAbout::create([
            'title'       => ['az' => '166 Usta haqqında', 'en' => 'About 166 Usta', 'ru' => 'О 166 Уста'],
            'content'     => ['az' => '<p>166 Usta, Bakıda peşəkar ev təmir xidmətləri göstərən etibarlı bir şirkətdir. 2018-ci ildən bəri fəaliyyət göstərən komandamız minlərlə müştəriyə xidmət etmişdir.</p><p>Mebel quraşdırılması, santexnik, elektrik, kondisioner, boya-suvaq və daha çox xidmət sahəsində peşəkar ustalarımız hazırdır.</p>', 'en' => '<p>166 Usta is a reliable company providing professional home repair services in Baku. Our team, operating since 2018, has served thousands of customers.</p><p>Our professional craftsmen are ready in furniture assembly, plumbing, electrical, AC and more.</p>', 'ru' => '<p>166 Уста — надёжная компания, предоставляющая профессиональные услуги по ремонту дома в Баку. Наша команда, работающая с 2018 года, обслужила тысячи клиентов.</p><p>Наши профессиональные мастера готовы в сборке мебели, сантехнике, электрике, кондиционировании и многом другом.</p>'],
            'button_text' => ['az' => 'Ətraflı oxu', 'en' => 'Read more', 'ru' => 'Читать далее'],
            'button_url'  => '/az/haqqimizda',
        ]);

        // --- Home CTA ---
        HomeCta::create([
            'title'       => ['az' => 'Usta lazımdır?', 'en' => 'Need a craftsman?', 'ru' => 'Нужен мастер?'],
            'description' => ['az' => 'Zəng edin, 30 dəqiqə ərzində ustamız yanınızda olacaq!', 'en' => 'Call us, our craftsman will be with you within 30 minutes!', 'ru' => 'Позвоните нам, наш мастер будет у вас в течение 30 минут!'],
            'button_text' => ['az' => 'İndi zəng et', 'en' => 'Call now', 'ru' => 'Позвонить сейчас'],
            'button_url'  => 'tel:+994000000000',
        ]);

        // --- Home Why Us ---
        HomeWhyUs::create([
            'title'    => ['az' => 'Niyə 166 Usta?', 'en' => 'Why 166 Usta?', 'ru' => 'Почему 166 Уста?'],
            'subtitle' => ['az' => 'Bizi seçmək üçün 4 əsas səbəb', 'en' => '4 main reasons to choose us', 'ru' => '4 главные причины выбрать нас'],
            'items'    => [
                ['title' => ['az' => 'Təcrübəli ustalar', 'en' => 'Experienced craftsmen', 'ru' => 'Опытные мастера'], 'description' => ['az' => '5+ il təcrübəli, sertifikatlı peşəkarlar', 'en' => '5+ years experienced, certified professionals', 'ru' => 'Профессионалы с опытом 5+ лет, сертифицированные'], 'image' => null],
                ['title' => ['az' => 'Sürətli xidmət', 'en' => 'Fast service', 'ru' => 'Быстрый сервис'], 'description' => ['az' => 'Müraciətdən 30-60 dəqiqə ərzində müdaxilə', 'en' => 'Response within 30-60 minutes of request', 'ru' => 'Выезд в течение 30-60 минут от обращения'], 'image' => null],
                ['title' => ['az' => 'Zəmanətli iş', 'en' => 'Guaranteed work', 'ru' => 'Гарантированная работа'], 'description' => ['az' => 'Bütün işlərə zəmanət verilir', 'en' => 'All works are guaranteed', 'ru' => 'На все работы предоставляется гарантия'], 'image' => null],
                ['title' => ['az' => 'Əlverişli qiymət', 'en' => 'Affordable price', 'ru' => 'Доступная цена'], 'description' => ['az' => 'Bazar qiymətlərindən aşağı, keyfiyyətdən güzəştsiz', 'en' => 'Below market prices, no compromise on quality', 'ru' => 'Ниже рыночных цен, без компромисса в качестве'], 'image' => null],
            ],
        ]);

        // --- Blog Tags ---
        $tag1 = BlogTag::create(['name' => 'Mebel', 'slug' => 'mebel']);
        $tag2 = BlogTag::create(['name' => 'Santexnik', 'slug' => 'santexnik']);
        $tag3 = BlogTag::create(['name' => 'Elektrik', 'slug' => 'elektrik']);
        $tag4 = BlogTag::create(['name' => 'Kondisioner', 'slug' => 'kondisioner']);

        // --- Blog Posts ---
        $post1 = BlogPost::create([
            'title'        => ['az' => 'Mebel quraşdırılmasında diqqət edilməli 5 məqam', 'en' => '5 things to consider in furniture assembly', 'ru' => '5 важных моментов при сборке мебели'],
            'slug'         => ['az' => 'mebel-qurasdirilmasinda-diqqet', 'en' => 'furniture-assembly-tips', 'ru' => 'sovet-po-sborke-mebeli'],
            'excerpt'      => ['az' => 'Mebel quraşdırılması zamanı edilən ən çox yayılmış səhvlər və onlardan necə qaçmaq olar.', 'en' => 'The most common mistakes made during furniture assembly and how to avoid them.', 'ru' => 'Самые распространённые ошибки при сборке мебели и как их избежать.'],
            'content'      => ['az' => '<p>Mebel quraşdırılması sadə görünsə də, bir sıra vacib məqamlara diqqət etmək lazımdır. Əks halda mebel düzgün işləməyəcək və ya tez xarab olacaq.</p><h2>1. Təlimatı diqqətlə oxuyun</h2><p>Hər mebelin özünəməxsus montaj qaydaları var. Təlimatı atlamaq ən çox edilən səhvlərdən biridir.</p><h2>2. Düzgün alətlərdən istifadə edin</h2><p>Yanlış alət mebelin hissələrini zədələyə bilər.</p><h2>3. Polşanı qoruyun</h2><p>Montaj zamanı polşa üzərindəki cızıqlardan qorunmaq üçün altlıq qoyun.</p>', 'en' => '<p>Although furniture assembly may seem simple, there are important points to pay attention to. Otherwise the furniture won\'t work properly or will break quickly.</p><h2>1. Read instructions carefully</h2><p>Each piece of furniture has its own assembly rules. Skipping instructions is one of the most common mistakes.</p><h2>2. Use the right tools</h2><p>Wrong tools can damage furniture parts.</p>', 'ru' => '<p>Хотя сборка мебели может казаться простой, необходимо обращать внимание на важные моменты. Иначе мебель не будет работать должным образом.</p><h2>1. Внимательно читайте инструкцию</h2><p>У каждой мебели свои правила сборки. Пропуск инструкции — одна из самых распространённых ошибок.</p>'],
            'is_active'    => true,
            'published_at' => Carbon::now()->subDays(5),
            'meta_title'       => ['az' => 'Mebel Quraşdırılması Məsləhətləri | 166 Usta', 'en' => 'Furniture Assembly Tips | 166 Usta', 'ru' => 'Советы по сборке мебели | 166 Уста'],
            'meta_description' => ['az' => 'Mebel quraşdırılmasında diqqət edilməli 5 vacib məqam.', 'en' => '5 important points to consider in furniture assembly.', 'ru' => '5 важных моментов при сборке мебели.'],
        ]);
        $post1->tags()->attach([$tag1->id]);

        $post2 = BlogPost::create([
            'title'        => ['az' => 'Evdə santexnik problemlərinin erkən əlamətləri', 'en' => 'Early signs of plumbing problems at home', 'ru' => 'Ранние признаки сантехнических проблем дома'],
            'slug'         => ['az' => 'santexnik-problemlerin-elamatleri', 'en' => 'plumbing-problems-signs', 'ru' => 'priznaki-santekhnicheskikh-problem'],
            'excerpt'      => ['az' => 'Böyük santexnik problemlər əvvəlcə kiçik əlamətlər verir. Onları vaxtında tanımaq çox vacibdir.', 'en' => 'Major plumbing problems first give small signs. Recognizing them in time is very important.', 'ru' => 'Крупные сантехнические проблемы сначала дают небольшие признаки. Очень важно вовремя их распознать.'],
            'content'      => ['az' => '<p>Santexnik problemlər çox vaxt kiçik əlamətlərlə başlayır. Bu əlamətlərə vaxtında diqqət etsəniz, böyük xərclər və zərərlərdən qaçına bilərsiniz.</p><h2>Su basıncının azalması</h2><p>Kran və ya duş başlığındakı su basıncının azalması boru sistemindəki problemin ilk əlamətidir.</p><h2>Qeyri-adi səslər</h2><p>Borulardan gələn gurultu, tıqqıldama kimi qeyri-adi səslər problem olduğunu göstərir.</p>', 'en' => '<p>Plumbing problems often start with small signs. If you pay attention to these signs in time, you can avoid major costs and damages.</p><h2>Decreased water pressure</h2><p>Decreased water pressure in faucets or showerheads is the first sign of a problem in the pipe system.</p>', 'ru' => '<p>Сантехнические проблемы часто начинаются с небольших признаков. Если вовремя обратить на них внимание, можно избежать крупных расходов.</p><h2>Снижение давления воды</h2><p>Снижение давления воды в кранах или душевых — первый признак проблемы в трубопроводе.</p>'],
            'is_active'    => true,
            'published_at' => Carbon::now()->subDays(12),
            'meta_title'       => ['az' => 'Santexnik Problem Əlamətləri | 166 Usta', 'en' => 'Plumbing Problem Signs | 166 Usta', 'ru' => 'Признаки сантехнических проблем | 166 Уста'],
            'meta_description' => ['az' => 'Evdə santexnik problemlərinin erkən əlamətlərini tanıyın.', 'en' => 'Recognize early signs of plumbing problems at home.', 'ru' => 'Распознайте ранние признаки сантехнических проблем дома.'],
        ]);
        $post2->tags()->attach([$tag2->id]);

        $post3 = BlogPost::create([
            'title'        => ['az' => 'Kondisioner baxımının vacibliyi', 'en' => 'Importance of AC maintenance', 'ru' => 'Важность технического обслуживания кондиционера'],
            'slug'         => ['az' => 'kondisioner-baximi', 'en' => 'ac-maintenance-importance', 'ru' => 'vazhnost-obsluzhivaniya-konditsionera'],
            'excerpt'      => ['az' => 'İllik kondisioner baxımı enerji qənaəti və uzun ömür üçün vacibdir. Baxım nə zaman edilməlidir?', 'en' => 'Annual AC maintenance is important for energy saving and long life. When should maintenance be done?', 'ru' => 'Ежегодное обслуживание кондиционера важно для экономии энергии и долгой службы. Когда нужно проводить ТО?'],
            'content'      => ['az' => '<p>Kondisioner sisteminiz düzgün işləsin deyə mütəmadi texniki baxım keçirilməlidir. Baxımsız qalan kondisionerlər daha çox enerji istehlak edir və tez xarab olur.</p><h2>Nə vaxt baxım etdirmək lazımdır?</h2><p>İldə ən azı bir dəfə — tercihen yay mövsümündən əvvəl — kondisionerin texniki baxımı edilməlidir.</p>', 'en' => '<p>Regular technical maintenance should be performed to keep your AC working properly. Unmaintained ACs consume more energy and break down sooner.</p><h2>When should maintenance be done?</h2><p>At least once a year — preferably before the summer season — AC maintenance should be performed.</p>', 'ru' => '<p>Необходимо регулярно проводить техническое обслуживание для правильной работы кондиционера. Кондиционеры без ТО потребляют больше энергии и быстрее выходят из строя.</p>'],
            'is_active'    => true,
            'published_at' => Carbon::now()->subDays(20),
            'meta_title'       => ['az' => 'Kondisioner Baxımı | 166 Usta', 'en' => 'AC Maintenance | 166 Usta', 'ru' => 'ТО кондиционера | 166 Уста'],
            'meta_description' => ['az' => 'Kondisioner baxımının vacibliyi haqqında faydalı məlumat.', 'en' => 'Useful information about the importance of AC maintenance.', 'ru' => 'Полезная информация о важности обслуживания кондиционера.'],
        ]);
        $post3->tags()->attach([$tag4->id]);

        // --- Portfolio Items ---
        PortfolioItem::create([
            'title'             => ['az' => 'Yasamal Dairəsində Mebel Montajı', 'en' => 'Furniture Assembly in Yasamal District', 'ru' => 'Сборка мебели в Ясамальском районе'],
            'slug'              => ['az' => 'yasamal-mebel-montaji', 'en' => 'yasamal-furniture-assembly', 'ru' => 'yasamal-sborka-mebeli'],
            'short_description' => ['az' => '3 otaqlı mənzildə tam mebel quraşdırılması işi. İKEA markası.', 'en' => 'Complete furniture assembly in a 3-room apartment. IKEA brand.', 'ru' => 'Полная сборка мебели в 3-комнатной квартире. Бренд IKEA.'],
            'content'           => ['az' => '<p>Yasamal rayonunda yerləşən 3 otaqlı mənzildə tam mebel quraşdırılması işini həyata keçirdik. Müştərinin sifariş etdiyi İKEA mebelini 1 gün ərzində quraşdırdıq.</p>', 'en' => '<p>We carried out complete furniture assembly in a 3-room apartment in Yasamal district. We assembled the customer\'s IKEA furniture within 1 day.</p>', 'ru' => '<p>Выполнили полную сборку мебели в 3-комнатной квартире в Ясамальском районе. Собрали мебель IKEA заказчика за 1 день.</p>'],
            'client'            => 'Nigar xanım',
            'duration'          => '1 gün',
            'service_id'        => $svc1->id,
            'order'             => 1,
            'is_active'         => true,
            'meta_title'       => ['az' => 'Yasamalda Mebel Montajı | 166 Usta', 'en' => 'Furniture Assembly Yasamal | 166 Usta', 'ru' => 'Сборка мебели Ясамал | 166 Уста'],
            'meta_description' => ['az' => '3 otaqlı mənzildə tam mebel quraşdırılması porfoliosu.', 'en' => 'Complete furniture assembly portfolio in 3-room apartment.', 'ru' => 'Портфолио полной сборки мебели в 3-комнатной квартире.'],
        ]);

        PortfolioItem::create([
            'title'             => ['az' => 'Nəsimi Rayonunda Santexnik İşlər', 'en' => 'Plumbing Work in Nasimi District', 'ru' => 'Сантехнические работы в Насиминском районе'],
            'slug'              => ['az' => 'nasimi-santexnik-isleri', 'en' => 'nasimi-plumbing-work', 'ru' => 'nasimi-santekhnicheskiye-raboty'],
            'short_description' => ['az' => 'Həmam və mətbəxdə tam santexnik yeniləmə. Boru dəyişimi, kran quraşdırılması.', 'en' => 'Complete plumbing renovation in bathroom and kitchen. Pipe replacement, faucet installation.', 'ru' => 'Полный ремонт сантехники в ванной и кухне. Замена труб, установка кранов.'],
            'content'           => ['az' => '<p>Nəsimi rayonunda həmam və mətbəxdə tam santexnik yeniləmə işi görüldü. Köhnə borular yenisi ilə əvəz edildi, yeni kranlar quraşdırıldı.</p>', 'en' => '<p>Complete plumbing renovation was done in the bathroom and kitchen in Nasimi district. Old pipes were replaced with new ones, new faucets were installed.</p>', 'ru' => '<p>Был выполнен полный ремонт сантехники в ванной и кухне в Насиминском районе. Старые трубы заменены новыми, установлены новые краны.</p>'],
            'client'            => 'Rauf bəy',
            'duration'          => '2 gün',
            'service_id'        => $svc2->id,
            'order'             => 2,
            'is_active'         => true,
            'meta_title'       => ['az' => 'Nəsimidə Santexnik | 166 Usta', 'en' => 'Plumbing Nasimi | 166 Usta', 'ru' => 'Сантехника Насими | 166 Уста'],
            'meta_description' => ['az' => 'Nəsimi rayonunda santexnik yeniləmə porfoliosu.', 'en' => 'Plumbing renovation portfolio in Nasimi district.', 'ru' => 'Портфолио ремонта сантехники в Насиминском районе.'],
        ]);

        PortfolioItem::create([
            'title'             => ['az' => 'Xətai Rayonunda Kondisioner Quraşdırılması', 'en' => 'AC Installation in Khatai District', 'ru' => 'Установка кондиционера в Хатаинском районе'],
            'slug'              => ['az' => 'xetai-kondisioner-qurasdirilmasi', 'en' => 'khatai-ac-installation', 'ru' => 'khatai-ustanovka-konditsionera'],
            'short_description' => ['az' => 'Ofis məkanında 3 ədəd Samsung kondisioner quraşdırılması.', 'en' => 'Installation of 3 Samsung air conditioners in office space.', 'ru' => 'Установка 3 кондиционеров Samsung в офисном помещении.'],
            'content'           => ['az' => '<p>Xətai rayonunda yerləşən ofis məkanında 3 ədəd Samsung kondisioner quraşdırıldı. Bütün quraşdırma işləri peşəkar şəkildə aparıldı.</p>', 'en' => '<p>3 Samsung air conditioners were installed in an office space in Khatai district. All installation work was carried out professionally.</p>', 'ru' => '<p>В офисном помещении в Хатаинском районе установлены 3 кондиционера Samsung. Все монтажные работы выполнены профессионально.</p>'],
            'client'            => 'ABC Şirkəti',
            'duration'          => '1 gün',
            'service_id'        => $svc4->id,
            'order'             => 3,
            'is_active'         => true,
            'meta_title'       => ['az' => 'Xətaida Kondisioner | 166 Usta', 'en' => 'AC Installation Khatai | 166 Usta', 'ru' => 'Кондиционер Хатаи | 166 Уста'],
            'meta_description' => ['az' => 'Ofisdə kondisioner quraşdırılması porfoliosu.', 'en' => 'AC installation portfolio in office.', 'ru' => 'Портфолио установки кондиционера в офисе.'],
        ]);

        // --- Boxes ---
        Box::create([
            'title'             => ['az' => 'Starter Paket', 'en' => 'Starter Package', 'ru' => 'Стартовый пакет'],
            'slug'              => ['az' => 'starter-paket', 'en' => 'starter-package', 'ru' => 'startovyy-paket'],
            'category'          => ['az' => 'Əsas Xidmətlər', 'en' => 'Basic Services', 'ru' => 'Базовые услуги'],
            'short_description' => ['az' => '1 otaq üçün əsas usta xidmətlərini əhatə edir. Mebel, elektrik, santexnik.', 'en' => 'Covers basic handyman services for 1 room. Furniture, electrical, plumbing.', 'ru' => 'Охватывает базовые услуги мастера для 1 комнаты. Мебель, электрика, сантехника.'],
            'content'           => ['az' => '<p>Starter Paket 1 otaq üçün ən zəruri usta xidmətlərini əhatə edir.</p><ul><li>1 mebel quraşdırılması</li><li>3 rozetka/açar dəyişimi</li><li>1 kran dəyişimi</li></ul>', 'en' => '<p>Starter Package covers the most essential handyman services for 1 room.</p><ul><li>1 furniture assembly</li><li>3 socket/switch replacements</li><li>1 faucet replacement</li></ul>', 'ru' => '<p>Стартовый пакет охватывает самые необходимые услуги мастера для 1 комнаты.</p><ul><li>Сборка 1 предмета мебели</li><li>Замена 3 розеток/выключателей</li><li>Замена 1 крана</li></ul>'],
            'price'  => 150.00, 'order' => 1, 'is_active' => true,
            'meta_title'       => ['az' => 'Starter Usta Paketi | 166 Usta', 'en' => 'Starter Handyman Package | 166 Usta', 'ru' => 'Стартовый пакет мастера | 166 Уста'],
            'meta_description' => ['az' => '150 AZN-ə 1 otaq üçün starter usta paketi.', 'en' => 'Starter handyman package for 1 room at 150 AZN.', 'ru' => 'Стартовый пакет мастера для 1 комнаты за 150 AZN.'],
        ]);

        Box::create([
            'title'             => ['az' => 'Standart Paket', 'en' => 'Standard Package', 'ru' => 'Стандартный пакет'],
            'slug'              => ['az' => 'standart-paket', 'en' => 'standard-package', 'ru' => 'standartnyy-paket'],
            'category'          => ['az' => 'Populyar Seçim', 'en' => 'Popular Choice', 'ru' => 'Популярный выбор'],
            'short_description' => ['az' => '2-3 otaq üçün geniş xidmət paketi. Ən çox seçilən seçim.', 'en' => 'Extended service package for 2-3 rooms. Most chosen option.', 'ru' => 'Расширенный пакет услуг для 2-3 комнат. Самый выбираемый вариант.'],
            'content'           => ['az' => '<p>Standart Paket 2-3 otaqlı ev üçün ideal seçimdir.</p><ul><li>3 mebel quraşdırılması</li><li>Tam elektrik yoxlanması</li><li>Santexnik baxım</li><li>Kondisioner servisi</li></ul>', 'en' => '<p>Standard Package is the ideal choice for a 2-3 room home.</p><ul><li>3 furniture assemblies</li><li>Full electrical inspection</li><li>Plumbing maintenance</li><li>AC service</li></ul>', 'ru' => '<p>Стандартный пакет — идеальный выбор для дома с 2-3 комнатами.</p><ul><li>Сборка 3 предметов мебели</li><li>Полная проверка электрики</li><li>Обслуживание сантехники</li><li>Сервис кондиционера</li></ul>'],
            'price'  => 350.00, 'order' => 2, 'is_active' => true,
            'meta_title'       => ['az' => 'Standart Usta Paketi | 166 Usta', 'en' => 'Standard Handyman Package | 166 Usta', 'ru' => 'Стандартный пакет мастера | 166 Уста'],
            'meta_description' => ['az' => '350 AZN-ə 2-3 otaq üçün standart usta paketi.', 'en' => 'Standard handyman package for 2-3 rooms at 350 AZN.', 'ru' => 'Стандартный пакет мастера для 2-3 комнат за 350 AZN.'],
        ]);

        Box::create([
            'title'             => ['az' => 'Premium Paket', 'en' => 'Premium Package', 'ru' => 'Премиум пакет'],
            'slug'              => ['az' => 'premium-paket', 'en' => 'premium-package', 'ru' => 'premium-paket'],
            'category'          => ['az' => 'VIP Xidmət', 'en' => 'VIP Service', 'ru' => 'VIP сервис'],
            'short_description' => ['az' => 'Tam mənzil üçün hərtərəfli xidmət paketi. Hər şey daxil.', 'en' => 'Comprehensive service package for full apartment. Everything included.', 'ru' => 'Комплексный пакет услуг для всей квартиры. Всё включено.'],
            'content'           => ['az' => '<p>Premium Paket tam mənzil üçün ən geniş xidmət paketimizdir.</p><ul><li>Limitsiz mebel quraşdırılması</li><li>Tam elektrik sistemi yenilənməsi</li><li>Tam santexnik yenilənməsi</li><li>Kondisioner quraşdırılması</li><li>Boya-suvaq məsləhəti</li></ul>', 'en' => '<p>Premium Package is our most comprehensive service package for full apartments.</p><ul><li>Unlimited furniture assembly</li><li>Full electrical system renewal</li><li>Full plumbing renewal</li><li>AC installation</li><li>Painting consultation</li></ul>', 'ru' => '<p>Премиум пакет — наш самый обширный пакет услуг для всей квартиры.</p><ul><li>Неограниченная сборка мебели</li><li>Полное обновление электросистемы</li><li>Полное обновление сантехники</li><li>Установка кондиционера</li><li>Консультация по покраске</li></ul>'],
            'price'  => 650.00, 'order' => 3, 'is_active' => true,
            'meta_title'       => ['az' => 'Premium Usta Paketi | 166 Usta', 'en' => 'Premium Handyman Package | 166 Usta', 'ru' => 'Премиум пакет мастера | 166 Уста'],
            'meta_description' => ['az' => '650 AZN-ə tam mənzil üçün premium usta paketi.', 'en' => 'Premium handyman package for full apartment at 650 AZN.', 'ru' => 'Премиум пакет мастера для всей квартиры за 650 AZN.'],
        ]);

        // --- Campaigns ---
        Campaign::create([
            'title'             => ['az' => 'Yay Endirim Kampaniyası', 'en' => 'Summer Discount Campaign', 'ru' => 'Летняя акция скидок'],
            'slug'              => ['az' => 'yay-endirim-kampaniyasi', 'en' => 'summer-discount-campaign', 'ru' => 'letnyaya-aktsiya-skidok'],
            'short_description' => ['az' => 'Bütün kondisioner quraşdırılma xidmətlərindən 20% endirim! Yalnız iyul ayında.', 'en' => '20% discount on all AC installation services! July only.', 'ru' => 'Скидка 20% на все услуги по установке кондиционеров! Только в июле.'],
            'content'           => ['az' => '<p>Yay istilərini rahat keçirin! İyul ayı ərzində bütün kondisioner quraşdırılma xidmətlərindən 20% endirim əldə edin.</p><p>Kampaniya 1-31 iyul tarixləri arasında keçərlidir. Sifariş vermək üçün indi zəng edin!</p>', 'en' => '<p>Have a comfortable summer! Get 20% discount on all AC installation services throughout July.</p><p>Campaign is valid from July 1-31. Call now to place an order!</p>', 'ru' => '<p>Проведите лето с комфортом! Получите скидку 20% на все услуги по установке кондиционеров в течение июля.</p><p>Акция действует с 1 по 31 июля. Звоните сейчас!</p>'],
            'starts_at'  => Carbon::now()->subDays(3),
            'ends_at'    => Carbon::now()->addDays(28),
            'is_active'  => true,
            'meta_title'       => ['az' => 'Yay Kondisioner Endirimi | 166 Usta', 'en' => 'Summer AC Discount | 166 Usta', 'ru' => 'Летняя скидка на кондиционер | 166 Уста'],
            'meta_description' => ['az' => 'Kondisioner quraşdırılmasında 20% endirim. Yalnız iyulda.', 'en' => '20% discount on AC installation. July only.', 'ru' => 'Скидка 20% на установку кондиционера. Только в июле.'],
        ]);

        Campaign::create([
            'title'             => ['az' => 'Paket Xidmətlərə 15% Endirim', 'en' => '15% Discount on Package Services', 'ru' => 'Скидка 15% на пакетные услуги'],
            'slug'              => ['az' => 'paket-xidmetlere-endirim', 'en' => 'package-services-discount', 'ru' => 'skidka-na-paketnye-uslugi'],
            'short_description' => ['az' => 'Standart və Premium paketlərə xüsusi endirim. İki xidmət birlikdə sifariş edəndə.', 'en' => 'Special discount on Standard and Premium packages. When ordering two services together.', 'ru' => 'Специальная скидка на стандартный и премиум пакеты. При заказе двух услуг вместе.'],
            'content'           => ['az' => '<p>Eyni anda iki xidmət sifarişi verdikdə 15% endirim əldə edirsiniz! Məsələn, mebel + santexnik, elektrik + kondisioner birlikdə sifariş edə bilərsiniz.</p>', 'en' => '<p>Get 15% discount when ordering two services at the same time! For example, you can order furniture + plumbing, electrical + AC together.</p>', 'ru' => '<p>При заказе двух услуг одновременно вы получаете скидку 15%! Например, можно заказать мебель + сантехника, электрика + кондиционер вместе.</p>'],
            'starts_at'  => Carbon::now(),
            'ends_at'    => Carbon::now()->addMonths(2),
            'is_active'  => true,
            'meta_title'       => ['az' => 'Paket Xidmət Endirimi | 166 Usta', 'en' => 'Package Service Discount | 166 Usta', 'ru' => 'Скидка на пакет услуг | 166 Уста'],
            'meta_description' => ['az' => 'İki xidmət birlikdə sifarişdə 15% endirim.', 'en' => '15% discount when ordering two services together.', 'ru' => 'Скидка 15% при заказе двух услуг вместе.'],
        ]);

        // --- Testimonials ---
        Testimonial::create([
            'customer_name' => 'Nigar Əliyeva',
            'position'      => ['az' => 'Ev xanımı', 'en' => 'Housewife', 'ru' => 'Домохозяйка'],
            'review_text'   => ['az' => 'Çox razı qaldım! Mebeli çox sürətli və səliqəli qurdular. Hər şeyi təmizlədilər. Tövsiyə edirəm.', 'en' => 'Very satisfied! They assembled the furniture very quickly and neatly. Cleaned everything up. I recommend.', 'ru' => 'Очень доволен! Собрали мебель очень быстро и аккуратно. Всё убрали. Рекомендую.'],
            'rating'        => 5,
            'service_id'    => $svc1->id,
            'order'         => 1,
            'is_active'     => true,
        ]);
        Testimonial::create([
            'customer_name' => 'Rauf Həsənov',
            'position'      => ['az' => 'Mühasib', 'en' => 'Accountant', 'ru' => 'Бухгалтер'],
            'review_text'   => ['az' => 'Santexnik ustası çox peşəkar idi. Problemi sürətlə həll etdi. Qiymət də əlverişliydi.', 'en' => 'The plumber was very professional. Solved the problem quickly. The price was also affordable.', 'ru' => 'Сантехник был очень профессиональным. Быстро решил проблему. Цена тоже была доступной.'],
            'rating'        => 5,
            'service_id'    => $svc2->id,
            'order'         => 2,
            'is_active'     => true,
        ]);
        Testimonial::create([
            'customer_name' => 'Aynur Məmmədova',
            'position'      => ['az' => 'Müəllimə', 'en' => 'Teacher', 'ru' => 'Учитель'],
            'review_text'   => ['az' => '166 Usta-nı dostuma tövsiyə etdim. Kondisioner quraşdırılmasında çox məmnun oldu. Yaxşı şirkətdir.', 'en' => 'I recommended 166 Usta to my friend. They were very satisfied with the AC installation. It\'s a good company.', 'ru' => 'Порекомендовала 166 Уста другу. Остался очень доволен установкой кондиционера. Хорошая компания.'],
            'rating'        => 5,
            'service_id'    => $svc4->id,
            'order'         => 3,
            'is_active'     => true,
        ]);
        Testimonial::create([
            'customer_name' => 'Elnur Quliyev',
            'position'      => ['az' => 'Sahibkar', 'en' => 'Entrepreneur', 'ru' => 'Предприниматель'],
            'review_text'   => ['az' => 'Ofisimin elektrik sistemini tamamilə yenilədilər. Peşəkar yanaşma, sürətli iş. Çox razıyam.', 'en' => 'They completely renewed my office electrical system. Professional approach, fast work. Very satisfied.', 'ru' => 'Полностью обновили электросистему в моём офисе. Профессиональный подход, быстрая работа. Очень доволен.'],
            'rating'        => 5,
            'service_id'    => $svc3->id,
            'order'         => 4,
            'is_active'     => true,
        ]);

        // --- Partners ---
        Partner::create(['name' => 'IKEA Azerbaijan', 'logo' => '', 'url' => null, 'order' => 1, 'is_active' => true]);
        Partner::create(['name' => 'Samsung', 'logo' => '', 'url' => null, 'order' => 2, 'is_active' => true]);
        Partner::create(['name' => 'LG Electronics', 'logo' => '', 'url' => null, 'order' => 3, 'is_active' => true]);
        Partner::create(['name' => 'Grohe', 'logo' => '', 'url' => null, 'order' => 4, 'is_active' => true]);

        // --- Privacy Page ---
        PrivacyPage::create([
            'content' => [
                'az' => '<h2>Məxfilik Siyasəti</h2><p>166 Usta olaraq müştərilərimizin şəxsi məlumatlarının qorunmasına böyük əhəmiyyət veririk.</p><h3>Hansı məlumatları toplayırıq?</h3><p>Saytımızdan istifadə zamanı ad, soyad, telefon nömrəsi və e-poçt ünvanı kimi əlaqə məlumatları toplanır.</p><h3>Məlumatlar necə istifadə olunur?</h3><p>Toplanan məlumatlar yalnız xidmət göstərilməsi məqsədi ilə istifadə edilir, üçüncü şəxslərə ötürülmür.</p>',
                'en' => '<h2>Privacy Policy</h2><p>At 166 Usta, we place great importance on protecting our customers\' personal data.</p><h3>What data do we collect?</h3><p>Contact information such as name, surname, phone number and email address is collected when using our website.</p><h3>How is data used?</h3><p>Collected data is used only for service provision purposes and is not transferred to third parties.</p>',
                'ru' => '<h2>Политика конфиденциальности</h2><p>В 166 Уста мы придаём большое значение защите персональных данных наших клиентов.</p><h3>Какие данные мы собираем?</h3><p>При использовании нашего сайта собираются контактные данные: имя, фамилия, телефон и электронная почта.</p><h3>Как используются данные?</h3><p>Собранные данные используются только для оказания услуг и не передаются третьим лицам.</p>',
            ],
        ]);
    }
}
