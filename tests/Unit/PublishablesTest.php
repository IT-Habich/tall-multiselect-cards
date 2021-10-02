<?php

use CodeAdminDe\TallMultiselectCards\Tests\TestCase;
use Illuminate\Support\Facades\File;

class PublishablesTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->configPath = config_path('tall-multiselect-cards.php');
        $this->resourcePathViews = resource_path('views/vendor/tall-multiselect-cards');
        $this->resourcePathLang = resource_path('lang/vendor/tall-multiselect-cards');
    }

    /** @test */
    function it_pubishes_config()
    {
        if (File::exists($this->configPath)) {
            unlink($this->configPath);
        }

        $this->assertFileDoesNotExist($this->configPath);
        $this->artisan('vendor:publish', ['--tag' => 'tall-multiselect-cards-config']);
        $this->assertFileExists($this->configPath);
        $this->assertFileIsReadable($this->configPath);
        $this->assertFileEquals($this->configPath, __DIR__ . '/../../config/tall-multiselect-cards.php');
        $this->assertTrue(unlink($this->configPath));
        $this->assertFileDoesNotExist($this->configPath);
    }
    
    /** @test */
    function it_pubishes_views()
    {
        if (File::exists($this->resourcePathViews)) {
            File::deleteDirectory($this->resourcePathViews);
        }

        $this->assertDirectoryDoesNotExist($this->resourcePathViews);
        $this->artisan('vendor:publish', ['--tag' => 'tall-multiselect-cards-views']);
        $this->assertDirectoryExists($this->resourcePathViews);
        $this->assertDirectoryIsReadable($this->resourcePathViews);
        $this->assertTrue(File::deleteDirectory($this->resourcePathViews));
        $this->assertDirectoryDoesNotExist($this->resourcePathViews);
    }

    /** @test */
    function it_pubishes_lang()
    {
        if (File::exists($this->resourcePathLang)) {
            File::deleteDirectory($this->resourcePathLang);
        }

        $this->assertDirectoryDoesNotExist($this->resourcePathLang);
        $this->artisan('vendor:publish', ['--tag' => 'tall-multiselect-cards-lang']);
        $this->assertDirectoryExists($this->resourcePathLang);
        $this->assertDirectoryIsReadable($this->resourcePathLang);
        $this->assertTrue(File::deleteDirectory($this->resourcePathLang));
        $this->assertDirectoryDoesNotExist($this->resourcePathLang);
    }
}
