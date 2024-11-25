<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // User FAQs
        $userFaqs = json_decode(file_get_contents(base_path('faqs/faq-users.jsonl')), true);
        foreach ($userFaqs as $index => $faq) {
            Faq::create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'role_id' => 3
            ]);
        }

        // Group Leader FAQs
        $glFaqs = json_decode(file_get_contents(base_path('faqs/faq-gl.jsonl')), true);
        foreach ($glFaqs as $index => $faq) {
            Faq::create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'role_id' => 2
            ]);
        }
    }
}
