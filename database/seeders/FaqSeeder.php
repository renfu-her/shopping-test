<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create FAQ Categories
        $generalCategory = FaqCategory::create([
            'title' => 'General Questions',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $shippingCategory = FaqCategory::create([
            'title' => 'Shipping & Delivery',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $paymentCategory = FaqCategory::create([
            'title' => 'Payment & Billing',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Create FAQs
        Faq::create([
            'category_id' => $generalCategory->id,
            'title' => 'What is your return policy?',
            'content' => 'We offer a 30-day return policy for all items. Items must be in original condition with tags attached.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'category_id' => $generalCategory->id,
            'title' => 'How can I contact customer service?',
            'content' => 'You can contact our customer service team via email at support@example.com or call us at 1-800-123-4567.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Faq::create([
            'category_id' => $shippingCategory->id,
            'title' => 'How long does shipping take?',
            'content' => 'Standard shipping takes 3-5 business days. Express shipping takes 1-2 business days.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'category_id' => $shippingCategory->id,
            'title' => 'Do you ship internationally?',
            'content' => 'Yes, we ship to most countries worldwide. International shipping takes 7-14 business days.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Faq::create([
            'category_id' => $paymentCategory->id,
            'title' => 'What payment methods do you accept?',
            'content' => 'We accept all major credit cards, PayPal, and bank transfers.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'category_id' => $paymentCategory->id,
            'title' => 'Is my payment information secure?',
            'content' => 'Yes, we use industry-standard SSL encryption to protect your payment information.',
            'sort_order' => 2,
            'is_active' => true,
        ]);
    }
}
