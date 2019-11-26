<!-- WPDM Link Template: Call to Action 3 -->

<div class="well c2a3">
    <div class="media">
        <div class="pull-left" align="left">
            [icon]
        </div>
        <div class="pull-right" align="right" style="font-family: 'Roboto';">
            <!-- chèn nút xem tài liệu bên download -->
            <span style="padding-right: 7px; cursor: pointer;" onclick="toggle_viewer('[download_url]');">Xem<span id="spanviewer"><!-- (Ẩn) --></span></span><span>[download_link]</span>
        </div>

        <div class="media-body">
            <h3 class="media-heading" style="padding-top: 0px;border:0px;margin: 0 0 5px 0;font-size:12pt;"><a style="font-weight: 700" href="[page_url]">[title]</a> <span style="margin-left:30px;font-size:8pt;font-weight:300"><i style="margin: 2px 0 0 5px;opacity:0.5" class="fa fa-th-large"></i> [file_size] <i style="margin: 2px 0 0 5px;opacity:0.5" class="fa fa-download"></i> [download_count] downloads</span></h3>
            [excerpt_40]
        </div>

    </div>
    <!-- thêm đoạn xem tài liệu -->
    <div id="[download_url]" style="display: none; margin-top: 10px;">
        <!-- code hiển thị tài liệu vs width và height -->
        <iframe src="//docs.google.com/viewer?url=[download_url]&amp;embedded=true&amp;hl=en" title="Embedded Document" style="width:100%; height:500px; border: none;"></iframe>
        <!-- [embeddoc url="http://thcsvanlang.pgdviettri.edu.vn/upload/41185/20180401/TKB_NAM_2017-2018_LAN_6_XONG.xls" viewer="google"] -->

    </div>
    <!-- kết thúc đoạn xem tài liệu -->
</div>
<style>.well.c2a3 .btn.wpdm-download-link{ padding: 11px 30px;font-size: 11pt; } .well.c2a3 .media-body{ font-size: 11pt; } .well.c2a3 .wpdm_icon{ height: 42px; width: auto; } .well.c2a3 .wpdm-download-link img{ max-width: 150px; box-shadow: none }</style>
<script type="text/javascript">
    function toggle_viewer(id) {
        var e = document.getElementById(id);
        if (e.style.display == 'block') 
        {
            e.style.display = 'none';
        } else 
        {
            e.style.display = 'block';
        }
        // sau khi hiện tài liệu, đồng thời nhảy đến vị trí xem tài liệu
        document.getElementById(id).scrollIntoView();
    }
</script>