# API Undangan

Base URL production: `https://inv.kuymase.com/api`

## Autentikasi

Semua endpoint `/v1` membutuhkan header Bearer Token. Nilainya berasal dari environment variable `WHATSAPP_WEBHOOK_TOKEN` pada server. Jangan masukkan token ini ke frontend atau repository.

```http
Authorization: Bearer <WHATSAPP_WEBHOOK_TOKEN>
Accept: application/json
Content-Type: application/json
```

Endpoint `GET /invitation` bersifat publik dan dibatasi 30 request per menit. Endpoint ini menerima kode undangan melalui query `inv` atau Bearer Token, lalu mengembalikan nama tamu dan batas jumlah tamu. Jika kode tidak dikenal, responsnya tetap `200` dengan `{"message":"Undangan umum."}`.

## Ringkasan endpoint

| Method | Path | Fungsi |
| --- | --- | --- |
| `GET` | `/invitation?inv={kode}` | Memeriksa detail undangan publik |
| `GET` | `/v1/invitations` | List undangan |
| `POST` | `/v1/invitations` | Membuat undangan |
| `DELETE` | `/v1/invitations/{guest_id}` | Menghapus undangan dan RSVP terkait |
| `GET` | `/v1/rsvps` | List RSVP |
| `PATCH` | `/v1/rsvps/{guest_id}/reply` | Menulis balasan pemilik pada RSVP |
| `GET` | `/v1/guests/{guest_id}` | Detail undangan (alias kompatibilitas) |
| `POST` | `/v1/guests/{guest_id}/rsvp` | Membuat atau memperbarui RSVP |
| `POST` | `/v1/guests/{guest_id}/rsvp/reply` | Alias kompatibilitas untuk balasan |

`/v1/guests` dan `/v1/invitations` berbagi data dan perilaku yang sama. ID pada path adalah ID numerik guest, bukan kode `inv`.

## Memeriksa undangan publik

```http
GET /api/invitation?inv={invitation_token}
```

Contoh respons untuk undangan yang valid:

```json
{
  "name": "Nama Tamu",
  "max_guests": 2
}
```

Kode personal untuk tautan website memakai format `https://inv.kuymase.com/?inv={invitation_token}`. Kode ini berbeda dari Bearer Token API.

## Membuat undangan

```http
POST /api/v1/invitations
```

Body JSON:

```json
{
  "name": "Nama Tamu",
  "phone": "+62 812-3456-7890",
  "max_guests": 2
}
```

`name` wajib (maksimal 120 karakter), `phone` wajib dan unik (8–20 digit; tanda baca akan dihapus), `max_guests` opsional (1–20, default `1`).

Respons `201 Created` berisi `data`, `invitation_token`, dan URL personal:

```json
{
  "message": "Tamu berhasil dibuat.",
  "data": {
    "id": 12,
    "name": "Nama Tamu",
    "phone": "6281234567890",
    "max_guests": 2,
    "rsvp": null,
    "created_at": "2026-10-20T10:00:00+07:00"
  },
  "invitation_token": "<kode-undangan>",
  "invitation_url": "https://inv.kuymase.com/?inv=<kode-undangan>"
}
```

Simpan `invitation_url` untuk dibagikan ke tamu. Jangan membagikan Bearer Token API.

## List undangan

```http
GET /api/v1/invitations?q=andi&per_page=25
GET /api/v1/invitations?phone=62812345678
```

Query opsional:

| Nama | Keterangan |
| --- | --- |
| `q` | Cari nama; angka pada pencarian juga dipakai untuk mencocokkan nomor telepon jika minimal 8 digit |
| `phone` | Cari nomor telepon setelah karakter selain digit dihapus |
| `per_page` | Jumlah per halaman, 1–100; default 25 |

Respons menggunakan pagination Laravel: `data`, `links`, dan `meta`. Setiap entri `data` berisi detail tamu serta `rsvp` jika sudah ada.

## Hapus undangan

```http
DELETE /api/v1/invitations/12
```

Respons `200 OK`:

```json
{
  "message": "Undangan berhasil dihapus."
}
```

RSVP yang terkait ikut terhapus.

## Mengirim atau memperbarui RSVP

```http
POST /api/v1/guests/12/rsvp
```

Body untuk hadir:

```json
{
  "presence": "hadir",
  "guest_count": 2,
  "message": "Sampai bertemu di acara."
}
```

Body untuk tidak hadir:

```json
{
  "presence": "tidak",
  "message": "Mohon maaf, saya belum bisa hadir."
}
```

`presence` wajib berupa `hadir` atau `tidak`. `guest_count` wajib untuk `hadir` dan tidak boleh melebihi batas tamu undangan. `message` opsional (maksimal 1000 karakter). Endpoint ini melakukan upsert: RSVP yang sudah ada diperbarui.

## List RSVP

```http
GET /api/v1/rsvps?presence=hadir&q=andi&per_page=25
```

Filter opsional: `presence` (`hadir` atau `tidak`), `q` (nama tamu), dan `per_page` (1–100, default 25). Respons dipaginasi dan setiap entri memuat data guest, status hadir, jumlah tamu, pesan, balasan pemilik, dan waktu.

## Membalas RSVP

```http
PATCH /api/v1/rsvps/12/reply
```

Body JSON:

```json
{
  "owner_reply": "Terima kasih, sampai bertemu!"
}
```

`owner_reply` wajib berupa teks maksimal 1000 karakter. Path memakai `guest_id`. Jika tamu belum memiliki RSVP, API mengembalikan `404`.

## Contoh cURL

```bash
curl -X POST "https://inv.kuymase.com/api/v1/invitations" \
  -H "Authorization: Bearer $WHATSAPP_WEBHOOK_TOKEN" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Nama Tamu","phone":"081234567890","max_guests":2}'
```

## Kode status umum

| Status | Arti |
| --- | --- |
| `200` | Berhasil |
| `201` | Undangan berhasil dibuat |
| `401` | Bearer Token hilang atau salah |
| `404` | Guest/RSVP tidak ditemukan |
| `422` | Validasi gagal; respons berisi `message` dan `errors` |
| `503` | `WHATSAPP_WEBHOOK_TOKEN` belum dikonfigurasi di server |
