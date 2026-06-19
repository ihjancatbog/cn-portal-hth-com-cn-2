<?php

/**
 * site_meta.php
 *
 * 站点元信息配置与描述生成
 */

class SiteMeta {
    
    /**
     * @var array 站点元信息数据
     */
    private $meta = [];

    /**
     * 构造函数
     *
     * @param array $data 初始元数据
     */
    public function __construct(array $data = []) {
        $this->meta = $data;
    }

    /**
     * 设置元信息
     *
     * @param string $key 键名
     * @param mixed $value 值
     */
    public function set(string $key, $value): void {
        $this->meta[$key] = $value;
    }

    /**
     * 获取元信息
     *
     * @param string $key 键名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get(string $key, $default = null) {
        return $this->meta[$key] ?? $default;
    }

    /**
     * 生成简短描述文本（HTML转义后）
     *
     * @return string
     */
    public function generateShortDescription(): string {
        $title = $this->get('title', '站点');
        $keywords = $this->get('keywords', []);
        $desc = $this->get('description', '');
        
        $parts = [];
        $parts[] = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        
        if (!empty($keywords) && is_array($keywords)) {
            $kwStr = implode(', ', array_map(function($kw) {
                return htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
            }, $keywords));
            $parts[] = $kwStr;
        }
        
        if (!empty($desc)) {
            $shortDesc = mb_substr($desc, 0, 100);
            $parts[] = htmlspecialchars($shortDesc, ENT_QUOTES, 'UTF-8');
        }
        
        return implode(' - ', $parts);
    }

    /**
     * 导出所有元信息
     *
     * @return array
     */
    public function export(): array {
        return $this->meta;
    }
}

// 示例数据
$siteUrl = 'https://cn-portal-hth.com.cn';
$keyword = '华体会';

$metaData = [
    'title' => '华体会官方门户',
    'url' => $siteUrl,
    'keywords' => ['华体会', '体育', '娱乐', '资讯'],
    'description' => '华体会官方门户，提供最新体育资讯、赛事直播与娱乐互动，致力于为用户打造全方位的数字体验平台。',
    'author' => '华体会团队',
];

// 初始化
$siteMeta = new SiteMeta($metaData);

// 额外添加
$siteMeta->set('version', '1.0.0');
$siteMeta->set('language', 'zh-CN');

// 生成描述
$description = $siteMeta->generateShortDescription();

// 输出
echo "站点描述: " . $description . "\n";
echo "站点URL: " . htmlspecialchars($siteMeta->get('url'), ENT_QUOTES, 'UTF-8') . "\n";
echo "核心关键词: " . htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') . "\n";