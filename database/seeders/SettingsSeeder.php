<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Translatable settings stored as JSON
        $translatable = [
            'site_name'        => ['az' => '166 Usta',      'en' => '166 Usta',   'ru' => '166 Уста'],
            'site_tagline'     => ['az' => 'Peşəkar usta xidmətləri', 'en' => 'Professional handyman services', 'ru' => 'Профессиональные услуги мастера'],
            'meta_title'       => ['az' => '166 Usta | Peşəkar usta xidmətləri', 'en' => '166 Usta | Professional Handyman Services', 'ru' => '166 Уста | Профессиональные услуги'],
            'meta_description' => [
                'az' => 'Mebel, Santexnik, Elektrik, Qazanxana və digər usta xidmətləri - 166 Usta ilə həll edin.',
                'en' => 'Furniture, Plumbing, Electrical, Heating and other handyman services - solve with 166 Usta.',
                'ru' => 'Мебель, Сантехника, Электрика, Котельная и другие услуги мастера - решите с 166 Уста.',
            ],
            'meta_keywords'    => [
                'az' => 'usta, mebel, santexnik, elektrik, bakı, xidmət',
                'en' => 'handyman, furniture, plumbing, electrical, baku, service',
                'ru' => 'мастер, мебель, сантехника, электрика, баку, услуги',
            ],
        ];

        foreach ($translatable as $key => $value) {
            Setting::set($key, json_encode($value, JSON_UNESCAPED_UNICODE));
        }

        // Plain settings
        $plain = [
            'site_logo'           => '',
            'site_favicon'        => '',
            'phone'               => '+994 00 000 00 00',
            'phone2'              => '',
            'email'               => 'info@166usta.az',
            'address'             => 'Yasamal rayon, Ə.Əhmədov 21 B',
            'working_hours'       => 'B.E - C: 09:00 - 18:00',
            'facebook'            => '',
            'instagram'           => '',
            'whatsapp'            => '',
            'tiktok'              => '',
            'youtube'             => '',
            'og_image'            => '',
            'google_analytics'    => '',
            'google_tag_manager'  => '',
            'google_verification' => '',
            'robots_txt'          => "User-agent: *\nAllow: /\nDisallow: /admin/",
        ];

        foreach ($plain as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
