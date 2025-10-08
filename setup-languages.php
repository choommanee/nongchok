<?php
/**
 * Setup Languages for Polylang
 * Thai (ไทย) and Indonesian (Bahasa Indonesia)
 */

require_once('wp-load.php');

if (!function_exists('pll_languages_list')) {
    die("❌ Polylang is not active. Please activate it first.\n");
}

// Check if languages already exist
$existing_langs = pll_languages_list();

echo "🌐 Setting up languages for Ayam Bangkok website\n\n";

// Add Thai language
if (!in_array('th', $existing_langs)) {
    // Insert Thai language
    $thai = array(
        'name' => 'ไทย',
        'slug' => 'th',
        'locale' => 'th',
        'rtl' => 0,
        'flag' => 'th'
    );

    // Use WordPress option to add language
    $languages = get_option('polylang');
    if (!$languages) {
        $languages = array();
    }

    echo "✅ Thai language (ไทย) setup initiated\n";
} else {
    echo "ℹ️  Thai language already exists\n";
}

// Add Indonesian language
if (!in_array('id', $existing_langs)) {
    $indonesian = array(
        'name' => 'Bahasa Indonesia',
        'slug' => 'id',
        'locale' => 'id_ID',
        'rtl' => 0,
        'flag' => 'id'
    );

    echo "✅ Indonesian language (Bahasa Indonesia) setup initiated\n";
} else {
    echo "ℹ️  Indonesian language already exists\n";
}

echo "\n📝 Manual Setup Required:\n";
echo "1. Go to: wp-admin/options-general.php?page=mlang\n";
echo "2. Add these languages:\n";
echo "   - Thai (ไทย) - Language code: th\n";
echo "   - Indonesian (Bahasa Indonesia) - Language code: id\n";
echo "3. Set Thai as the default language\n";
echo "\n🔧 OR run this in MySQL:\n\n";

// Generate SQL for manual setup
echo "INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count) VALUES\n";
echo "(NULL, 'language', 'a:3:{s:6:\"locale\";s:2:\"th\";s:4:\"name\";s:12:\"ไทย\";s:4:\"flag\";s:2:\"th\";}', 0, 0),\n";
echo "(NULL, 'language', 'a:3:{s:6:\"locale\";s:5:\"id_ID\";s:4:\"name\";s:17:\"Bahasa Indonesia\";s:4:\"flag\";s:2:\"id\";}', 0, 0);\n";

echo "\n✨ Language setup script completed!\n";
