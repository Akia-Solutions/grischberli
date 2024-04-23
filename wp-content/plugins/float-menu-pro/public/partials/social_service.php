<?php
/**
 * Social Services Array link
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$share_title = get_the_title();
$share_url   = get_permalink();


$social_services = array(
	'facebook'         => 'https://www.facebook.com/sharer/sharer.php?u=' . $share_url,
	'vk'               => 'http://vk.com/share.php?url=' . $share_url,
	'twitter'          => 'https://twitter.com/share?url=' . $share_url . '&text=' . $share_title,
	'linkedin'         => 'https://www.linkedin.com/shareArticle?url=' . $share_url . '&title=' . $share_title,
	'odnoklassniki'    => 'http://ok.ru/dk?st.cmd=addShare&st._surl=' . $share_url,
	'google'           => 'https://plus.google.com/share?url=' . $share_url,
	'pinterest'        => 'https://pinterest.com/pin/create/button/?url=' . $share_url,
	'xing'             => 'https://www.xing.com/spi/shares/new?url=' . $share_url,
	'myspace'          => 'https://myspace.com/post?u=' . $share_url . '&t=' . $share_title,
	'weibo'            => 'http://service.weibo.com/share/share.php?url=' . $share_url . '&title=' . $share_title,
	'buffer'           => 'https://buffer.com/add?text=' . $share_title . '&url=' . $share_url,
	'stumbleupon'      => 'http://www.stumbleupon.com/submit?url=' . $share_url . '&title=' . $share_title,
	'reddit'           => 'http://www.reddit.com/submit?url=' . $share_url . '&title=' . $share_title,
	'tumblr'           => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . $share_url . '&title=' . $share_title,
	'blogger'          => 'https://www.blogger.com/blog-this.g?u=' . $share_url . '&n=' . $share_title,
	'livejournal'      => 'http://www.livejournal.com/update.bml?subject=' . $share_title . '&event=' . $share_url,
	'pocket'           => 'https://getpocket.com/save?url=' . $share_url,
	'telegram'         => 'https://telegram.me/share/url?url=' . $share_url . '&text=' . $share_title,
	'skype'            => 'https://web.skype.com/share?url=' . $share_url,
	'email'            => 'mailto:?subject=' . $share_title . '&body=' . $share_url,
	'draugiem'         => 'https://www.draugiem.lv/say/ext/add.php?title=' . $share_title . '&url=' . $share_url,
	'whatsapp'         => 'whatsapp://send?text=' . $share_title . '%20%0A' . $share_url,
	'diaspora'         => 'https://share.diasporafoundation.org/?title=' . $share_title . '&url=' . $share_url,
	'digg'             => 'http://digg.com/submit?url=' . $share_url,
	'douban'           => 'http://www.douban.com/recommend/?url=' . $share_url . '&title=' . $share_title,
	'evernote'         => 'http://www.evernote.com/clip.action?url=' . $share_url . '&title=' . $share_title,
	'flipboard'        => 'https://share.flipboard.com/bookmarklet/popout?v=2&title=' . $share_title . '&url=' . $share_url,
	'google-bookmarks' => 'https://www.google.com/bookmarks/mark?op=edit&bkmk=' . $share_url . '&title='. $share_title,
	'hacker-news'      => 'https://news.ycombinator.com/submitlink?u=' . $share_url . '&t='. $share_title,
	'instapaper'       => 'http://www.instapaper.com/edit?url=' . $share_url . '&title='. $share_title,
	'line'             => 'https://lineit.line.me/share/ui?url=' . $share_url . '',
	'qzone'            => 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' . $share_url . '',
	'renren'           => 'http://widget.renren.com/dialog/share?resourceUrl=' . $share_url . '&srcUrl=' . $share_url . '&title='. $share_title,
);