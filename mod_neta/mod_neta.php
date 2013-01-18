<?php
class mod_neta extends ModuleHelper {
	private $NETA_LABEL = '[NETABARE_ARI]';

	public function getModuleName() {
		return $this->moduleBuilder('劇情洩漏隱藏');
	}

	public function getModuleVersionInfo() {
		return '7th.Release (v130118)';
	}

	public function autoHookHead(&$dat) {
		$dat .= '<script type="text/javascript">
// <![CDATA[
jQuery(function($){
	$(\'div.threadpost, div.reply\').find(\'span[id^=neta] > a\').bind(\'click\', function(){
		$(this).parent().parent().find(\'*[id^=neta]\')
			.filter(\'span\').hide().end()
			.filter(\'div\').slideDown();
		return false;
	});
});
// ]]>
</script>
';
	}

	public function autoHookPostInfo(&$postinfo) {
		$postinfo .= '<li><b>要捏他，請在內文使用<span style="color:blue;">'.
			$this->NETA_LABEL.'</span>標籤註明劇情洩漏！</b></li>'."\n";
	}

	public function autoHookThreadPost(&$arrLabels, $post, $isReply) {
		$this->netaCollapse($arrLabels, $post, $isReply);
	}

	public function autoHookThreadReply(&$arrLabels, $post, $isReply) {
		$this->netaCollapse($arrLabels, $post, $isReply);
	}

	/**
	 * 處理劇情洩漏隱藏
	 *
	 * @param  array   $arrLabels 標籤
	 * @param  array   $post      文章陣列
	 * @param  boolean $isReply   是否為回應模式
	 */
	private function netaCollapse(&$arrLabels, $post, $isReply) {
		$labelLength = strlen($this->NETA_LABEL.'<br />');
		$labelPosition = strpos($arrLabels['{$COM}'], $this->NETA_LABEL.'<br />');
		if ($labelPosition !== false) {
			$arrLabels['{$COM}'] = substr_replace(
				$arrLabels['{$COM}'],
				'<div class="hide" id="netacoll'.$arrLabels['{$NO}'].'">',
				$labelPosition,
				$labelLength
			).'</div>';
			$arrLabels['{$WARN_BEKILL}'] .= '<span class="warn_txt2" id="netabar'.
				$arrLabels['{$NO}'].'">這篇文章可能含有劇情洩漏，要閱讀全文請按下<a href="#">此處</a>展開。<br /></span>'."\n";
		}
	}
}