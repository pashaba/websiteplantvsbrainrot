export default async function handler(req, res) {
  try {
    const response = await fetch("https://plantsvsbrainrot.com/api/seed-shop.php", {
      headers: {
        "User-Agent": "Mozilla/5.0 (PlantsvsBrainrot Custom Endpoint)",
      },
    });

    if (!response.ok) {
      return res.status(response.status).json({ error: "Gagal mengambil data asli" });
    }

    const data = await response.json();

    // Kamu bisa ubah struktur JSON di sini kalau mau modifikasi
    const customData = {
      status: "success",
      updatedAt: new Date().toISOString(),
      source: "plantsvsbrainrot.com",
      totalSeeds: data.seeds?.length || 0,
      totalGear: data.gear?.length || 0,
      nextUpdate: data.nextUpdateAt,
      seeds: data.seeds,
      gear: data.gear,
    };

    res.status(200).json(customData);
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Terjadi kesalahan saat mengambil data", details: err.message });
  }
}
