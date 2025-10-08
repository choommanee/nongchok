(function($){
  $(function(){
    console.log('[About Admin] script loaded');

    // Default tab activation
    var $tabs = $('.nav-tab');
    var $contents = $('.tab-content');
    if ($tabs.length && $contents.length) {
      if (!$tabs.filter('.nav-tab-active').length) {
        $tabs.removeClass('nav-tab-active').first().addClass('nav-tab-active');
      }
      var activeTab = $tabs.filter('.nav-tab-active').data('tab');
      $contents.hide();
      if (activeTab) { $('#'+activeTab).show(); } else { $contents.first().show(); }
    }

    // Tab switching
    $(document).on('click', '.nav-tab', function(e){
      e.preventDefault();
      var target = $(this).data('tab');
      if (!target) return;
      $('.nav-tab').removeClass('nav-tab-active');
      $(this).addClass('nav-tab-active');
      $('.tab-content').hide();
      $('#'+target).show();
    });

    // Media uploader
    $(document).on('click', '.media-button', function(e){
      e.preventDefault();
      var target = $(this).data('target');
      var mediaUploader = wp.media({ title: 'เลือกรูปภาพ', button: { text: 'เลือก' }, multiple: false });
      mediaUploader.on('select', function(){
        var attachment = mediaUploader.state().get('selection').first().toJSON();
        $('#'+target).val(attachment.url);
      });
      mediaUploader.open();
    });

    // Import default data
    $('#import-default-data').on('click', function(){
      // Company Info
      $('#company_name').val('Ayam Bangkok');
      $('#company_description').val('Main company description + หนองจอก เอฟซีไอ เป็นตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย');
      $('#company_vision').val('มุ่งมั่นเป็นผู้นำด้านการส่งออกไก่ชนคุณภาพสูงจากประเทศไทยสู่ตลาดอินโดนีเซีย');
      $('#company_mission').val('ส่งมอบบริการที่เชื่อถือได้และพัฒนามาตรฐานอย่างต่อเนื่อง เพื่อความพึงพอใจของลูกค้า');

      // Timeline
      $('#timeline-container').empty();
      var timelineData = [
        {year: '2014', title: 'ก่อตั้งบริษัท', description: 'เริ่มต้นธุรกิจส่งออกไก่ชน'},
        {year: '2016', title: 'ขยายเครือข่าย', description: 'สร้างพันธมิตรในอินโดนีเซียหลายจังหวัด'},
        {year: '2019', title: 'มาตรฐานใหม่', description: 'ได้รับการรับรองมาตรฐานจากหน่วยงานรัฐที่เกี่ยวข้อง'},
        {year: '2020', title: 'เทคโนโลยีใหม่', description: 'นำเทคโนโลยีสมัยใหม่มาใช้ในการดูแลและขนส่งไก่ชน'},
        {year: '2024', title: 'ผู้นำในตลาด', description: 'ก้าวสู่ผู้นำในการส่งออกไก่ชนไปอินโดนีเซีย'}
      ];
      timelineData.forEach(function(item, index){
        // create minimal inputs if templates not rendered yet
        if (!$('#timeline-container .timeline-item').length) {
          $('#timeline-container').append(
            '<div class="timeline-item"><table class="form-table">'
            +'<tr><th>ปี</th><td><input type="text" name="timeline['+index+'][year]"></td></tr>'
            +'<tr><th>หัวข้อ</th><td><input type="text" name="timeline['+index+'][title]"></td></tr>'
            +'<tr><th>คำอธิบาย</th><td><textarea name="timeline['+index+'][description]"></textarea></td></tr>'
            +'</table></div>'
          );
        } else {
          // if templates exist, append another empty block by cloning last
          var $clone = $('#timeline-container .timeline-item').last().clone();
          $clone.find('input,textarea').val('');
          $('#timeline-container').append($clone);
        }
        $('input[name="timeline['+index+'][year]"]').val(item.year);
        $('input[name="timeline['+index+'][title]"]').val(item.title);
        $('textarea[name="timeline['+index+'][description]"]').val(item.description);
      });

      // Awards
      $('#awards-container').empty();
      var awardsData = [
        {title: 'รางวัลผู้ส่งออกดีเด่น', year: '2023', description: 'จากกรมการค้าต่างประเทศ กระทรวงพาณิชย์'},
        {title: 'ใบรับรองมาตรฐาน ISO', year: '2022', description: 'มาตรฐานการจัดการคุณภาพระดับสากล'},
        {title: 'รางวัลพันธมิตรทางการค้าดีเด่น', year: '2021', description: 'จากสถานเอกอัครราชทูตอินโดนีเซีย'}
      ];
      awardsData.forEach(function(item, index){
        if (!$('#awards-container .award-item').length) {
          $('#awards-container').append(
            '<div class="award-item"><table class="form-table">'
            +'<tr><th>ชื่อรางวัล</th><td><input type="text" name="awards['+index+'][title]"></td></tr>'
            +'<tr><th>ปี</th><td><input type="text" name="awards['+index+'][year]"></td></tr>'
            +'<tr><th>คำอธิบาย</th><td><textarea name="awards['+index+'][description]"></textarea></td></tr>'
            +'</table></div>'
          );
        } else {
          var $cloneA = $('#awards-container .award-item').last().clone();
          $cloneA.find('input,textarea').val('');
          $('#awards-container').append($cloneA);
        }
        $('input[name="awards['+index+'][title]"]').val(item.title);
        $('input[name="awards['+index+'][year]"]').val(item.year);
        $('textarea[name="awards['+index+'][description]"]').val(item.description);
      });

      // Team
      $('#team-container').empty();
      var teamData = [
        {name: 'คุณสมชาย ใจดี', position: 'ผู้อำนวยการ', description: 'ประสบการณ์กว่า 15 ปีในธุรกิจการส่งออกไก่ชน'},
        {name: 'คุณสมหญิง รักษ์ดี', position: 'ผู้จัดการฝ่ายขาย', description: 'เชี่ยวชาญด้านการตลาดและการขายระหว่างประเทศ'},
        {name: 'คุณสมศักดิ์ เก่งมาก', position: 'ผู้เชี่ยวชาญด้านไก่ชน', description: 'ความรู้เชิงลึกเกี่ยวกับการเลี้ยงและดูแลไก่ชน'}
      ];
      teamData.forEach(function(item, index){
        if (!$('#team-container .team-item').length) {
          $('#team-container').append(
            '<div class="team-item"><table class="form-table">'
            +'<tr><th>ชื่อ</th><td><input type="text" name="team['+index+'][name]"></td></tr>'
            +'<tr><th>ตำแหน่ง</th><td><input type="text" name="team['+index+'][position]"></td></tr>'
            +'<tr><th>คำอธิบาย</th><td><textarea name="team['+index+'][description]"></textarea></td></tr>'
            +'</table></div>'
          );
        } else {
          var $cloneT = $('#team-container .team-item').last().clone();
          $cloneT.find('input,textarea').val('');
          $('#team-container').append($cloneT);
        }
        $('input[name="team['+index+'][name]"]').val(item.name);
        $('input[name="team['+index+'][position]"]').val(item.position);
        $('textarea[name="team['+index+'][description]"]').val(item.description);
      });

      // Features (structured)
      $('#features-container').empty();
      var featuresData = [
        {title:'ประสบการณ์กว่า 10 ปี', description:'ความเชี่ยวชาญในการส่งออกไก่ชนคุณภาพสูง', icon:'fas fa-award'},
        {title:'ใบรับรองมาตรฐาน', description:'ได้รับการรับรองจากหน่วยงานราชการที่เกี่ยวข้อง', icon:'fas fa-certificate'},
        {title:'เครือข่ายระหว่างประเทศ', description:'ความสัมพันธ์ที่แน่นแฟ้นกับพันธมิตรในอินโดนีเซีย', icon:'fas fa-globe'}
      ];
      featuresData.forEach(function(f){
        $('#features-container').append(
          '<div class="feature-item" style="border:1px solid #eee; padding:10px; margin-bottom:10px;">'
          +'<table class="form-table">'
          +'<tr><th>หัวข้อ</th><td><input type="text" name="company_features_title[]" class="regular-text" value="'+ (f.title||'').replace(/"/g,'&quot;') +'"></td></tr>'
          +'<tr><th>รายละเอียด</th><td><textarea name="company_features_description[]" rows="2" class="large-text">'+ (f.description||'').replace(/</g,'&lt;') +'</textarea></td></tr>'
          +'<tr><th>ไอคอน (CSS Class)</th><td><input type="text" name="company_features_icon[]" class="regular-text" placeholder="เช่น fas fa-award" value="'+ (f.icon||'').replace(/"/g,'&quot;') +'"></td></tr>'
          +'</table>'
          +'</div>'
        );
      });

      // Values
      $('#values-container').empty();
      var valuesData = [
        {title:'ความใส่ใจ', description:'ใส่ใจในทุกรายละเอียดของการดูแลไก่ชนและบริการลูกค้า', icon:'fas fa-hand-holding-heart'},
        {title:'ความน่าเชื่อถือ', description:'สร้างความเชื่อมั่นด้วยคุณภาพและการบริการที่สม่ำเสมอ', icon:'fas fa-shield-alt'},
        {title:'นวัตกรรม', description:'พัฒนาและปรับปรุงวิธีการทำงานอย่างต่อเนื่อง', icon:'fas fa-lightbulb'},
        {title:'ความซื่อสัตย์', description:'ดำเนินธุรกิจด้วยความโปร่งใสและเป็นธรรม', icon:'fas fa-scale-balanced'}
      ];
      valuesData.forEach(function(v, idx){
        $('#values-container').append(
          '<div class="value-item" style="border:1px solid #eee; padding:10px; margin-bottom:10px;">'
          +'<table class="form-table">'
          +'<tr><th>หัวข้อ</th><td><input type="text" name="company_values['+idx+'][title]" class="regular-text"></td></tr>'
          +'<tr><th>รายละเอียด</th><td><textarea name="company_values['+idx+'][description]" rows="2" class="large-text"></textarea></td></tr>'
          +'<tr><th>ไอคอน (CSS Class)</th><td><input type="text" name="company_values['+idx+'][icon]" class="regular-text" placeholder="เช่น fas fa-heart"></td></tr>'
          +'</table>'
          +'</div>'
        );
        $('input[name="company_values['+idx+'][title]"]').val(v.title);
        $('textarea[name="company_values['+idx+'][description]"]').val(v.description);
        $('input[name="company_values['+idx+'][icon]"]').val(v.icon);
      });

      alert('นำเข้าข้อมูลเริ่มต้นเรียบร้อยแล้ว!');
    });
  });
})(jQuery);
