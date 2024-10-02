<?php

namespace GiveCloudflareTurnstile\Tests\Unit\FormExtension\Actions;

use Exception;
use Give\DonationForms\Models\DonationForm;
use Give\Tests\TestCase;
use Give\Tests\TestTraits\RefreshDatabase;
use GiveCloudflareTurnstile\FormExtension\DonationForm\Actions\AddFieldToFormSchema;
use GiveCloudflareTurnstile\Tests\Unit\TestTraits\HasCloudFlareTurnstileSettings;

/**
 * @since 1.0.0
 */
class TestAddFieldToFormSchema extends TestCase
{
    use HasCloudFlareTurnstileSettings;
    use RefreshDatabase;

    /**
     * @since 1.0.0
     * @throws Exception
     */
    public function testShouldReturnEarlyIfSettingIsDisabled(): void
    {
        /** @var DonationForm $donationForm */
        $donationForm = DonationForm::factory()->create();
        $this->setupCloudflareTurnstileSettings();
        give_update_option('givewp_donation_forms_cloudflare_turnstile_enabled', 'disabled');

        $schema = $donationForm->schema();
        give(AddFieldToFormSchema::class)($schema, $donationForm->id);

        $this->assertNull($schema->getNodeByName('turnstile'));
    }

    /**
     * @since 1.0.0
     * @throws Exception
     */
    public function testShouldReturnEarlyIfFilterIsDisabled(): void
    {
        /** @var DonationForm $donationForm */
        $donationForm = DonationForm::factory()->create();
        $this->setupCloudflareTurnstileSettings();
        give_update_option('givewp_donation_forms_cloudflare_turnstile_enabled', 'enabled');
        add_filter('give_cloudflare_turnstile_enabled', '__return_false');

        $schema = $donationForm->schema();
        give(AddFieldToFormSchema::class)($schema, $donationForm->id);

        $this->assertNull($schema->getNodeByName('turnstile'));
    }

    /**
     * @since 1.0.0
     * @throws Exception
     */
    public function testShouldReturnEarlyIfMissingSiteKey(): void
    {
        /** @var DonationForm $donationForm */
        $donationForm = DonationForm::factory()->create();
        $this->setupCloudflareTurnstileSettings();
        give_update_option('givewp_donation_forms_cloudflare_turnstile_enabled', 'enabled');
        give_update_option('givewp_cloudflare_turnstile_site_key', '');

        $schema = $donationForm->schema();
        give(AddFieldToFormSchema::class)($schema, $donationForm->id);

        $this->assertNull($schema->getNodeByName('turnstile'));
    }

    /**
     * @since 1.0.0
     * @throws Exception
     */
    public function testShouldReturnEarlyIfMissingSecretKey(): void
    {
        /** @var DonationForm $donationForm */
        $donationForm = DonationForm::factory()->create();
        $this->setupCloudflareTurnstileSettings();
        give_update_option('givewp_donation_forms_cloudflare_turnstile_enabled', 'enabled');
        give_update_option('givewp_cloudflare_turnstile_secret_key', '');

        $schema = $donationForm->schema();
        give(AddFieldToFormSchema::class)($schema, $donationForm->id);

        $this->assertNull($schema->getNodeByName('turnstile'));
    }

    /**
     * @since 1.0.0
     * @throws Exception
     */
    public function testShouldAddFieldToFormSchema(): void
    {
        /** @var DonationForm $donationForm */
        $donationForm = DonationForm::factory()->create();
        $this->setupCloudflareTurnstileSettings();
        give_update_option('givewp_donation_forms_cloudflare_turnstile_enabled', 'enabled');

        $schema = $donationForm->schema();
        give(AddFieldToFormSchema::class)($schema, $donationForm->id);

        $this->assertNotNull($schema->getNodeByName('turnstile'));
    }
}
