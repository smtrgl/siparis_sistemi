# Sipariş Takip Sistemi

Bu sistem, firmaların mobil cihazları üzerinden kağıt-kalem kullanmadan sipariş toplamalarını sağlayan **SaaS tabanlı bir platformdur**.  

## Temel Özellikler
- **Multi-Firma & Multi-User**: Birden fazla firma ve çalışan için kullanıcı yönetimi.
- **Abonelik Yönetimi**: 1, 3, 6 ay ve 1 yıl paketleri; kullanıcı sayısına göre limitler.
- **Firma Admin Paneli**: Sipariş takibi, WhatsApp gönderimi, kullanıcı ve rol yönetimi.
- **Global Admin Paneli**: Tüm firmaların aboneliklerini ve içeriklerini yönetme.
- **WhatsApp Entegrasyonu**: Siparişler belirlenen formatta ve numaraya gönderilir.
- **Mobil Uyumluluk & Modern Tasarım**: Kolay anlaşılır, responsive arayüz.
- **Raporlama**: Kullanıcı performansı, sipariş grafikleri, Excel/PDF export.
- **Abonelik Otomasyonu**: Bitiş uyarıları, yenileme hatırlatmaları.

## Amaç
Firmaların satış ekipleri, kendi telefonlarını kullanarak **hızlı ve hatasız sipariş alabilir**, siparişler anında yönetici panelinde görülebilir ve opsiyonel olarak WhatsApp üzerinden müşteriye iletilebilir.  

## Kurulum
1. MySQL veritabanı oluşturun ve `siparis_db.sql` dosyasını import edin.  
2. `config.php` içindeki veritabanı bilgilerini güncelleyin.  
3. Dosyaları web sunucusuna yükleyin.  
4. .htaccess ile firma slug yönlendirmesini aktif edin.  
5. Global admin paneli ile abonelik paketlerini ve index içeriğini oluşturun.
