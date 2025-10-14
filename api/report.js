import { MongoClient } from "mongodb";

const uri = process.env.MONGO_URI; // kita ambil dari environment variable
let client;

async function connectDB() {
  if (!client) {
    client = new MongoClient(uri);
    await client.connect();
  }
  return client.db("pvb").collection("report");
}

export default async function handler(req, res) {
  if (req.method === "POST") {
    try {
      const { name, description, screenshot } = req.body;
      if (!description) {
        return res.status(400).json({ error: "Deskripsi wajib diisi" });
      }

      const collection = await connectDB();
      await collection.insertOne({
        name: name || "Anonim",
        description,
        screenshot: screenshot || null,
        createdAt: new Date(),
      });

      res.status(200).json({ message: "Laporan berhasil disimpan ✅" });
    } catch (err) {
      console.error(err);
      res.status(500).json({ error: "Gagal menyimpan laporan" });
    }
  } else if (req.method === "GET") {
    try {
      const collection = await connectDB();
      const reports = await collection.find().sort({ createdAt: -1 }).toArray();
      res.status(200).json(reports);
    } catch (err) {
      res.status(500).json({ error: "Gagal mengambil data laporan" });
    }
  } else {
    res.status(405).json({ error: "Metode tidak diizinkan" });
  }
}
