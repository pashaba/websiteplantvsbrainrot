import { MongoClient } from "mongodb";

const uri = process.env.MONGO_URI; // Gunakan nama variabel standar dari Vercel
if (!uri) throw new Error("❌ MONGO_URI belum diset di environment variable");

let client;
let clientPromise;

// Cache client supaya tidak reconnect setiap request (penting di Vercel)
if (!global._mongoClientPromise) {
  client = new MongoClient(uri);
  global._mongoClientPromise = client.connect();
}
clientPromise = global._mongoClientPromise;

// Fungsi koneksi database
async function connectDB() {
  const client = await clientPromise;
  return client.db("pvb").collection("report"); // Nama DB & koleksi
}

export default async function handler(req, res) {
  if (req.method === "POST") {
    try {
      const { name, description, screenshot } = req.body;

      if (!description?.trim()) {
        return res.status(400).json({ error: "Deskripsi wajib diisi." });
      }

      const collection = await connectDB();

      await collection.insertOne({
        name: name?.trim() || "Anonim",
        description: description.trim(),
        screenshot: screenshot || null,
        createdAt: new Date(),
      });

      return res.status(200).json({ message: "✅ Laporan berhasil disimpan." });
    } catch (err) {
      console.error("Error saat menyimpan laporan:", err);
      return res.status(500).json({ error: "❌ Gagal menyimpan laporan." });
    }
  }

  // Ambil semua laporan
  else if (req.method === "GET") {
    try {
      const collection = await connectDB();
      const reports = await collection.find().sort({ createdAt: -1 }).toArray();
      return res.status(200).json(reports);
    } catch (err) {
      console.error("Error saat mengambil laporan:", err);
      return res.status(500).json({ error: "❌ Gagal mengambil data laporan." });
    }
  }

  // Kalau bukan GET/POST
  else {
    res.setHeader("Allow", ["GET", "POST"]);
    return res.status(405).json({ error: "❌ Metode tidak diizinkan." });
  }
    }
