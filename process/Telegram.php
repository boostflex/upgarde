<?php

require_once './config.php';
class Telegram
{
    private string $botToken;
    private string $chatId;
    private string $apiUrl;

    public function __construct()
    {
        $this->botToken = TELEGRAM_BOT_TOKEN;
        $this->chatId = TELEGRAM_CHAT_ID;
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
    }

    /**
     * Kirim pesan ke Telegram dengan MarkdownV2
     */
    public function send(string $message): bool
    {
        $payload = [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => 'markdown'
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload),
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("Telegram Error: $error");
            return false;
        }

        $data = json_decode($response, true);
        return $data['ok'] ?? false;
    }

    /**
     * Escape karakter khusus agar valid di MarkdownV2 Telegram
     */
    private function escapeMarkdown(string $text): string
    {
        $specials = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        foreach ($specials as $char) {
            $text = str_replace($char, '\\' . $char, $text);
        }
        return $text;
    }
}
