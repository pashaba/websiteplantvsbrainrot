export default async function handler(req, res) {
  try {
    const response = await fetch("https://plantsvsbrainrot.com/api/seed-shop.php");
    const data = await response.json();
    
    res.setHeader("Access-Control-Allow-Origin", "*");
    res.setHeader("Content-Type", "application/json");
    res.status(200).json(data);
  } catch (error) {
    res.status(500).json({ error: "Gagal mengambil data dari API" });
  }
}
