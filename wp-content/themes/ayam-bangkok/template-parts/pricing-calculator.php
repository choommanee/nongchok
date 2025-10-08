<?php
/**
 * Pricing Calculator Template Part
 */
?>

<div class="pricing-calculator-widget">
    <div class="calculator-header">
        <h3><?php echo isset($atts['title']) ? esc_html($atts['title']) : __('เครื่องคำนวณราคา', 'ayam-bangkok'); ?></h3>
    </div>
    
    <form class="mini-pricing-form">
        <div class="form-group">
            <label for="mini-rooster-count"><?php _e('จำนวนไก่ชน', 'ayam-bangkok'); ?></label>
            <input type="number" id="mini-rooster-count" name="rooster_count" min="1" value="1" required>
        </div>
        
        <div class="form-group">
            <label for="mini-rooster-breed"><?php _e('สายพันธุ์', 'ayam-bangkok'); ?></label>
            <select id="mini-rooster-breed" name="rooster_breed" required>
                <option value=""><?php _e('เลือกสายพันธุ์', 'ayam-bangkok'); ?></option>
                <option value="thai-native" data-price="5000"><?php _e('ไก่ไทยพื้นเมือง', 'ayam-bangkok'); ?></option>
                <option value="fighting-cock" data-price="8000"><?php _e('ไก่ชนแท้', 'ayam-bangkok'); ?></option>
                <option value="premium-breed" data-price="12000"><?php _e('สายพันธุ์พรีเมียม', 'ayam-bangkok'); ?></option>
                <option value="champion-line" data-price="20000"><?php _e('สายแชมป์', 'ayam-bangkok'); ?></option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="mini-service-package"><?php _e('แพ็กเกจบริการ', 'ayam-bangkok'); ?></label>
            <select id="mini-service-package" name="service_package" required>
                <option value=""><?php _e('เลือกแพ็กเกจ', 'ayam-bangkok'); ?></option>
                <option value="basic" data-price="2000"><?php _e('แพ็กเกจพื้นฐาน', 'ayam-bangkok'); ?></option>
                <option value="standard" data-price="3500"><?php _e('แพ็กเกจมาตรฐาน', 'ayam-bangkok'); ?></option>
                <option value="premium" data-price="5000"><?php _e('แพ็กเกจพรีเมียม', 'ayam-bangkok'); ?></option>
                <option value="vip" data-price="8000"><?php _e('แพ็กเกจ VIP', 'ayam-bangkok'); ?></option>
            </select>
        </div>
        
        <div class="calculator-result-mini">
            <div class="price-display">
                <span class="price-label"><?php _e('ราคาประมาณการ:', 'ayam-bangkok'); ?></span>
                <span class="price-value" id="mini-total-price">0 <?php _e('บาท', 'ayam-bangkok'); ?></span>
            </div>
        </div>
        
        <div class="calculator-actions-mini">
            <button type="button" id="mini-calculate-btn" class="btn btn-primary btn-small">
                <?php _e('คำนวณ', 'ayam-bangkok'); ?>
            </button>
            <a href="<?php echo esc_url(home_url('/pricing/')); ?>" class="btn btn-outline btn-small">
                <?php _e('ดูรายละเอียด', 'ayam-bangkok'); ?>
            </a>
        </div>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    // Mini calculator functionality
    $('#mini-rooster-count, #mini-rooster-breed, #mini-service-package').on('change input', function() {
        calculateMiniPrice();
    });
    
    $('#mini-calculate-btn').on('click', function() {
        calculateMiniPrice();
    });
    
    function calculateMiniPrice() {
        var count = parseInt($('#mini-rooster-count').val()) || 1;
        var breedPrice = parseInt($('#mini-rooster-breed option:selected').data('price')) || 0;
        var servicePrice = parseInt($('#mini-service-package option:selected').data('price')) || 0;
        
        var roosterTotal = breedPrice * count;
        var total = roosterTotal + servicePrice + 1000; // Base shipping
        
        // Simple volume discount
        if (count >= 5) {
            total = total * 0.9; // 10% discount
        } else if (count >= 3) {
            total = total * 0.95; // 5% discount
        }
        
        $('#mini-total-price').text(new Intl.NumberFormat('th-TH').format(Math.round(total)) + ' บาท');
        
        // Animation
        $('.price-value').addClass('price-updated');
        setTimeout(function() {
            $('.price-value').removeClass('price-updated');
        }, 500);
    }
});
</script>

<style>
.pricing-calculator-widget {
    background: white;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    padding: 1.5rem;
    margin: 1rem 0;
}

.calculator-header h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.mini-pricing-form .form-group {
    margin-bottom: 1rem;
}

.mini-pricing-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    font-size: 0.9rem;
}

.mini-pricing-form input,
.mini-pricing-form select {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    font-size: 0.9rem;
}

.calculator-result-mini {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 6px;
    margin: 1rem 0;
    text-align: center;
}

.price-display {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price-label {
    font-weight: 600;
    color: #6c757d;
}

.price-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--primary-color);
    transition: all 0.3s ease;
}

.price-value.price-updated {
    transform: scale(1.1);
    color: var(--secondary-color);
}

.calculator-actions-mini {
    display: flex;
    gap: 0.5rem;
}

.calculator-actions-mini .btn {
    flex: 1;
    text-align: center;
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}
</style>