<?php

use Illuminate\Database\Seeder;

class SiteOptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('site_option')->truncate();
        $siteOptions = [];
        $options = [
            [
                'key' => 'NAME',
                'value' => 'GOBYART',
                'option_input' => 'text',
                'type' => 'SITE',
            ],
            [   'key' => 'KEYWORD',
                'value' =>  'Agency, Agentur, Beauty, Body, Booking, Deutschland, Foot, Feet, Hand, Hands, Foto, Photo, Germany, Hamburg, International, Ice, Lifstyle, Woman, Frau, Frauen, Frauenmodel, Frauenmodelagentur, Model, Modelagency, Modelagentur, Modell, Models, Scout, Sedcard, Shooting, Shootings, Talent, Weibliche, Fotomodelle, Frauenbooking, Gesicht, Gesichter, Face, Faces, Fuß, Füße, Hände, Comp Card, Sed-Karte, Portfolio, Modelbook',
                'option_input' => 'textarea',
                'type' => 'SITE',
            ],
            [  'key' => 'COPY_RIGHT',
                'value' =>  'Copyright GobyArt. All rights reserved.',
                'option_input' => 'text',
                'type' => 'SITE',
            ],
            [
                'key' => 'YOUTUBE_HOME',
                'value' =>  'PARTNER_TYPE',
                'option_input' => 'text',
                'type' => 'SITE',
            ],
            [
                'key' => 'FACEBOOK',
                'value' =>  'TEST',
                'option_input' => 'text',
                'type' => 'SITE'
            ],
            [
                'key' => 'YOUTUBE_CHANNEL',
                'value' =>  'TEST',
                'option_input' => 'text',
                'type' => 'SITE',
            ],
            [
                'key' => 'DESCRIPTION',
                'value' =>  'Goby Art là trung tâm chuyên cung cấp nhân sự tổ chức sự kiện, với một cơ sở dữ liệu khổng lồ gồm các nhân sự chuyên nghiệp trong các lĩnh vực biểu  diễn nghệ thuật: ca sỹ, nhóm nhảy, nhóm múa, MC, xiếc, ban nhạc, người mẫu ... với phong cách tự tin chuyên nghiệp sẽ làm sự kiện của bạn nổi bật.',
                'option_input' => 'textarea',
                'type' => 'SITE_DESCRIPTION'
            ],
            [
                'key' => 'ABOUT_FOOTER',
                'value' =>  '<p>Goby Art là trung tâm chuyên cungcấp nhân sự tổ chức sự kiện, với một cơsở dữ liệu khổng lồ gồm các nhânsự chuyên nghiệp trong các lĩnh vực biểudiễn nghệ thuật: ca sỹ, nhóm nhảy, nhóm múa, MC, xiếc, ban nhạc, người mẫu ... với phong cách tự tin chuyên nghiệp sẽ làm sự kiện của bạn nổi bật.
<br/>Chúng tôi tự tin là những chuyên gia trong lĩnh vực giải trí, bằng sự lắng nghe và thấu hiểu những băn khoăn của khách hàng, Goby Art sẽ tư vấn và đưa ra các giải pháp phù hợp với mức độ chuyên nghiệp của chương trình</p>',
                'option_input' => 'html',
                'type' => 'SITE_DESCRIPTION'
            ],
            [
                'key' => 'ADDRESS_FOOTER',
                'value' =>  '<p><b>GOBY ART</b><br>Tầng 8 Tòa nhà Hanoi Cretive City<br>Số 1 Lương Yên Hai Bà Trưng Hà Nội<br><br><a href="mailto:gobyartagency@gmail.com"> gobyartagency@gmail.com</a></p>',
                'option_input' => 'html',
                'type' => 'SITE_DESCRIPTION'
            ],
            [
                'key' => 'PHONE',
                'value' =>  '<u>096 2525 890</u>',
                'option_input' => 'html',
                'type' => 'SITE_DESCRIPTION'
            ],
            [
                'key' => 'EMAIL_ADDRESS',
                'value' =>  'gobyart@gobyart.vn',
                'option_input' => 'text',
                'type' => 'SITE'
            ],
            [
                'key' => 'URL',
                'value' =>  'www.gobyart.vn',
                'option_input' => 'text',
                'type' => 'SITE'
            ],
            [
                'key' => 'LOCATION_LONGITUDE',
                'value' =>  '105.8630329',
                'option_input' => 'text',
                'type' => 'SITE_LOCATION'
            ],
            [
                'key' => 'LOCATION_LATITUDE',
                'value' =>  '21.8630329',
                'option_input' => 'text',
                'type' => 'SITE_LOCATION'
            ],
            [
                'key' => 'HEIGHT',
                'value' =>  '',
                'option_input' => 'text',
                'type' => 'ARTIST_OPTIONS'
            ],
            [
                'key' => 'HAIR',
                'value' =>  '',
                'option_input' => 'text',
                'type' => 'ARTIST_OPTIONS'
            ],
            [
                'key' => 'WAIST',
                'value' =>  '',
                'option_input' => 'text',
                'type' => 'ARTIST_OPTIONS'
            ],
            [
                'key' => 'BUST',
                'value' =>  '',
                'option_input' => 'text',
                'type' => 'ARTIST_OPTIONS'
            ],
            [
                'key' => 'HIPS',
                'value' =>  '',
                'option_input' => 'text',
                'type' => 'ARTIST_OPTIONS'
            ]
        ];

        foreach($options as $index => $data) {
            Log::info('data',$data);
            Log::info('index'.$index);
            $siteOptions[] = [
                'name' =>   $data['key'],
                'value' =>  $data['value'],
                'option_input' =>  $data['option_input'],
                'type' =>  $data['type'],
                'order' =>  DB::raw('(select ifnull(max(g.order), 0) + 1 from `site_option` as g)'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ];
        }

        DB::table('site_option')->insert($siteOptions);
    }
}
