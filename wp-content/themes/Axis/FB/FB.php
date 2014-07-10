<?php
require 'updater.php';

class FB
{
  private static $im;
  private static $updater;
  private static $theme;
  private static $themeName;
  private static $wpVersion;

  // Инициализация
  // Определение основных переменных и запуск базовых функций
  static public function init()
  {
    self::$im = new FB;

    // Включаем все хуки для wordpress
    self::$im->anchors();

    self::$im->theme = wp_get_theme();

    // Переводим № версии в число: 3.8.3 -> 3.8
    self::$im->wpVersion = floatval(get_bloginfo('version'));

    self::$im->themeName = self::$im->theme->get('Name');

    // Запускаем класс обновления темы
    self::$im->updater = new ThemeUpdateChecker(
         // Папка темы
         self::$im->themeName,
         // json-URL информация о текущей версии темы на сервере
        'http://www.fabthemes.com/versions/' . strtolower(str_replace(' ', '-', self::$im->themeName)) . '.json'
    );
  }

  static public function theme()
  {
    return self::$im;
  }

  /* Хуки для Wordpress */
  private function anchors()
  {
    add_filter('admin_head', array(FB::theme(), 'addUpgradeButton'));
  }

  /* Ф-я добавляет в админку (окно выбора тем)
   * кнопки для покупки коммерческой лицензии
   */
  public function addUpgradeButton()
  {
    // Butt in the popup description
    $popupButtText = 'Learn more about commercial license';
    // Butt in wp versions > 3.8 (main page)
    $buttText = 'Upgrade';
    // Text before button
    $textBeforeButt = 'Free wordpress theme for Non-commercial use.';

    // Similar
    $js = '';
    $_findTheme = '';
    $_findParentButt = '';
    $_buttParent = '<a target=\"_blank\" style=\"box-shadow: 0 1px 0 #68BE43 inset !important; border-color: #00A218; background-color: #35AE2D;\" class=\"buttBuyMe button button-primary\" href=\"https://fabthemes.com/order/license?theme='.$this->themeName.'&domain=' . $_SERVER['HTTP_HOST'] . '\">' . $buttText . '</a>';
    $_findOverlayButt = '';
    $_buttOverlay = '<a target=\"_blank\" id=\"ButtButMeDesc\" style=\"box-shadow: 0 1px 0 #68BE43 inset !important; border-color: #00A218; background-color: #35AE2D;\" class=\"buttBuyMe button button-primary\" href=\"https://fabthemes.com/order/license?theme='.$this->themeName.'&domain=' . $_SERVER['HTTP_HOST'] . '\">' . $popupButtText . '</a>';
    $_findOverlay = '';

    // Difference
    if ($this->wpVersion < 3.4) { /* 2, 2.5 */
    }
    elseif ($this->wpVersion <= 3.4) {
        $_findParentButt = '.action-links > ul';
        $_findTheme = 'jQuery("#availablethemes h3:contains(\'' . $this->themeName . '\')").closest(".available-theme")';
        $_findOverlayButt = 'jQuery("#current-theme h4:contains(\'' . $this->themeName . '\')").closest("#current-theme").find(".theme-info")';
        $_buttOverlay = '<div style=\"margin: 0 0 15px;\"><a target=\"_blank\" id=\"ButtButMeDesc\" style=\"padding: 8px 8px 8px 8px;\" class=\"buttBuyMe button button-primary\" href=\"https://fabthemes.com/order/license?theme='.$this->themeName.'&domain=' . $_SERVER['HTTP_HOST'] . '\">Buy Commercial Usage License</a></div>';
    }
    elseif ($this->wpVersion < 3.8) { /* 3.5, 3.6, 3.7 */
        $_findParentButt = '.action-links > ul';
        $_findOverlayButt = 'jQuery("#current-theme h4:contains(\'' . $this->themeName . '\')").closest("#current-theme").find(".theme-info")';
        $_buttOverlay = '<div style=\"margin: 15px 0 15px 0;\"><a target=\"_blank\" id=\"ButtButMeDesc\" class=\"buttBuyMe button button-primary\" href=\"https://fabthemes.com/order/license?theme='.$this->themeName.'&domain=' . $_SERVER['HTTP_HOST'] . '\">Buy Commercial Usage License</a></div>';
    }
    elseif ($this->wpVersion <= 3.9) {
        $_findParentButt = '.theme-actions';
        $_findTheme = 'jQuery(".themes > div[aria-describedby=\'' . $this->themeName . '-action ' . $this->themeName . '-name\']")';
        $_findOverlayButt = 'jQuery(".theme-wrap h3.theme-name:contains(\'' . $this->themeName . '\')")';
        $_buttOverlay = '<div style=\"margin: 10px 0 0;\">' . $_buttOverlay . '</div>';
        $textBeforeButt = '<div style=\"margin: 30px 0 0;\">' . $textBeforeButt . '</div>';
        $_findOverlay = '.theme[aria-describedby=\''.$this->themeName.'-action '.$this->themeName.'-name\'] > .theme-screenshot img, #'.$this->themeName.'-action, #'.$this->themeName.'-name, div[aria-describedby=\''.$this->themeName.'-action '.$this->themeName.'-name\'] .theme-actions';
    }

    // Main page butt "Upgrade"
    if ($this->wpVersion <= 3.9) {
      if (!empty($_findTheme) && !empty($_findParentButt) && !empty($_buttParent))
          $js .=
             $_findTheme . '.each(function () {
                jQuery(this).find("' . $_findParentButt . '").append("' . $_buttParent . '");
                jQuery(".buttBuyMe").on("mouseover", function() { jQuery(this).css({"background-color":"#409A39", "border-color": "#558B51"}); });
                jQuery(".buttBuyMe").on("mouseout", function() { jQuery(this).css({"background-color":"#35AE2D", "border-color":"#00A218"}); });
          });';
    }

    // If overlay already open
    if (!empty($_findOverlayButt) && !empty($_buttOverlay))
      // Определяем текст - назв. темы в заголовке
      $js .= $_findOverlayButt . '.after("' . $textBeforeButt . $_buttOverlay . '");';

    // Overlay
    if (!empty($_findOverlay) && !empty($_buttOverlay))
      $js .= '
          // If overlay just opened + 1 sec. interval
          var timerId;
          jQuery("' . $_findOverlay . '").on("click", function() {
            timerId = setInterval(function() {
              if (' . $_findOverlayButt . '.length != 0) {
                  ' . $_findOverlayButt . '.after("' . $textBeforeButt . $_buttOverlay . '");
                  jQuery("#ButtButMeDesc").fadeIn(250);
                  clearInterval(timerId);
              }
            }, 200);
          });
    ';

    $js .= '';

    echo '<script type="text/javascript">jQuery(window).load(function() {' . $js . '});</script>';
  }
}