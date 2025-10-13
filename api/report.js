import fs from "fs";
import path from "path";

export default async function handler(req, res) {
  if (req.method !== "POST") {
    return res.status(405).json({ error: "Method not allowed" });
  }

  try {
    const { name, description, screenshot } = req.body;

    if (!description) {
      return res.status(400).json({ error: "Deskripsi error wajib diisi." });
    }

    const report = {
      id: Date.now(),
      name: name || "Anonim",
      description,
      screenshot, // base64 image
      time: new Date().toISOString(),
    };

    const filePath = path.join(process.cwd(), "reports.json");
    let existing = [];

    try {
      const content = fs.readFileSync(filePath, "utf8");
      existing = JSON.parse(content);
    } catch {
      existing = [];
    }

    existing.push(report);
    fs.writeFileSync(filePath, JSON.stringify(existing, null, 2));

    res.status(200).json({ success: true, message: "Laporan berhasil dikirim!" });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Gagal menyimpan laporan." });
  }
}
