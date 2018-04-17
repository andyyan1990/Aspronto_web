(function($){
	$(document).ready(function(){
		var $media = false;
		if($('#windflaw-tmpl-format-meta-box').length && $('#formatdiv').length){
			var $format = $('#formatdiv'),
				$format_tmpl = $('#windflaw-tmpl-format-meta-box'),
				$title = false;
			function windflaw_sync_format_meta_box(format){
				var formats = ['audio', 'video'];
				$media.children('div.format').css('display', 'none');
				(format && (formats.indexOf(format) !== -1)) ? $media.children('div.format.' + format).add($title).css('display', '') : $title.css('display', 'none'); 
			}
			$format.find('.inside').append($format_tmpl.html());
			$media = $format.find('#windflaw-format-media');
			$title = $media.children('h4');
			windflaw_sync_format_meta_box(($format_tmpl.attr('data-format') || ''));
			$('body').on('change', 'input[name=post_format]', function(e){
				windflaw_sync_format_meta_box($(this).val());
			})
			.on('click', '#windflaw-format-media .format-media', function(e){
				e.preventDefault();
				if($(this).hasClass('video')){
					windflaw_format_media.video.open();
				}
				else if($(this).hasClass('audio')){
					windflaw_format_media.audio.open();
				}
			})
			.on('change', '#windflaw-format-media textarea', function(e){
				if($(this).siblings('input[type=hidden]').length){
					var $hidden = $(this).siblings('input[type=hidden]');
					$hidden.val('');
				}
			});
		}

		wp.windflaw = { };

		wp.windflaw_media_tools = function(){
			wp.windflaw.audio = new wp.media({
				library: {
					type : 'audio'
				},
				title: wp.media.view.l10n.addMedia,
				multiple: false
			});
			wp.windflaw.video = new wp.media({
				library: {
					type : 'video'
				},
				title: wp.media.view.l10n.addMedia,
				multiple: false
			});

			wp.windflaw.video.on('select', function(selection){
				var state = wp.windflaw.video.state(),
					video = {},
					attrs = {};
				selection = selection || state.get('selection').first();
				attrs= selection.toJSON();
				video = { width: attrs.width, height: attrs.height, src: attrs.url };
				$media.find('.video-id').val(attrs.id);
				$media.find('.video-code').val(wp.media.video.shortcode(video).string());
			})
			.on('open', function(){
				var selection = wp.windflaw.video.state().get('selection'),
					id = $media.find('.video-id').val();
				if(id){
					var attachment = wp.media.attachment(id);
					attachment.fetch();
					selection.add(attachment ? [attachment] : []);
				}
			});

			wp.windflaw.audio.on('select', function(selection){
				var state = wp.windflaw.audio.state(),
					audio = {},
					attrs = {};
				selection = selection || state.get('selection').first();
				attrs= selection.toJSON();
				audio['src'] = attrs.url;
				$media.find('.audio-id').val(attrs.id);
				$media.find('.audio-code').val(wp.media.audio.shortcode(audio).string());
			})
			.on('open', function(){
				var selection = wp.windflaw.audio.state().get('selection'),
					id = $media.find('.audio-id').val();
				if(id){
					var attachment = wp.media.attachment(id);
					attachment.fetch();
					selection.add(attachment ? [attachment] : []);
				}
			});

			return wp.windflaw;
		};

		var windflaw_format_media = new wp.windflaw_media_tools();
	});
})(jQuery);