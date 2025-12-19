# Smart PC Builder - Budget Allocation Strategy

## Tabel Alokasi Persentase Budget Per Komponen

### 1. GAMING BUILD

#### Best Performance (Fokus: Maximum FPS & Graphics Quality)
| Komponen | Persentase | Prioritas | Catatan |
|----------|-----------|-----------|---------|
| GPU (Graphics Card) | 40% | #1 | Komponen terpenting untuk gaming |
| CPU (Processor) | 20% | #2 | Balanced untuk gaming modern |
| RAM | 12% | #4 | 16GB DDR4 minimum |
| Storage (SSD) | 10% | #5 | NVMe untuk loading cepat |
| Motherboard | 10% | #3 | Support overclocking |
| PSU | 5% | #6 | 80+ Bronze minimum, cadangan 20% |
| Casing | 3% | #7 | Airflow baik |

#### Best Value (Fokus: Performance per Rupiah Terbaik)
| Komponen | Persentase | Prioritas | Catatan |
|----------|-----------|-----------|---------|
| GPU | 35% | #1 | Sweet spot performance |
| CPU | 22% | #2 | Mid-tier dengan value tinggi |
| RAM | 13% | #3 | 16GB DDR4 |
| Motherboard | 12% | #4 | Fitur standar, reliable |
| Storage | 10% | #5 | SSD SATA/NVMe entry |
| PSU | 5% | #6 | 80+ Bronze |
| Casing | 3% | #7 | Budget friendly |

#### Future Proof (Fokus: Upgrade Path & Longevity)
| Komponen | Persentase | Prioritas | Catatan |
|----------|-----------|-----------|---------|
| CPU | 25% | #1 | High-end untuk tahan lama |
| GPU | 30% | #2 | Upper mid-tier, upgradeable |
| Motherboard | 15% | #3 | Support gen terbaru |
| RAM | 12% | #4 | 32GB DDR4/DDR5 |
| Storage | 10% | #5 | 1TB NVMe Gen4 |
| PSU | 6% | #6 | 80+ Gold, overhead tinggi |
| Casing | 2% | #7 | Durable build quality |

---

### 2. OFFICE/ADMIN BUILD

#### Best Performance (Fokus: Multitasking & Responsiveness)
| Komponen | Persentase | Prioritas | Catatan |
|----------|-----------|-----------|---------|
| CPU | 30% | #1 | Multi-core untuk multitasking |
| RAM | 20% | #2 | 16GB untuk browser & apps |
| Storage | 20% | #3 | SSD untuk responsiveness |
| Motherboard | 15% | #4 | Stable & reliable |
| PSU | 8% | #5 | Efficient & quiet |
| Casing | 5% | #6 | Compact & professional |
| GPU | 2% | #7 | Integrated graphics cukup |

#### Best Value (Fokus: Efisiensi Biaya)
| Komponen | Persentase | Prioritas | Catatan |
|----------|-----------|-----------|---------|
| CPU | 28% | #1 | Entry-mid tier |
| Storage | 22% | #2 | SSD 512GB minimum |
| RAM | 18% | #3 | 8-16GB |
| Motherboard | 15% | #4 | Basic features |
| PSU | 10% | #5 | 80+ certified |
| Casing | 5% | #6 | Simple & functional |
| GPU | 2% | #7 | iGPU cukup |

#### Future Proof (Fokus: Expandability)
| Komponen | Persentase | Prioritas | Catatan |
|----------|-----------|-----------|---------|
| CPU | 32% | #1 | Support virtualization |
| RAM | 22% | #2 | 32GB untuk multitasking |
| Storage | 18% | #3 | Dual drive: NVMe + HDD |
| Motherboard | 15% | #4 | Multiple expansion slots |
| PSU | 8% | #5 | Modular, 80+ Gold |
| Casing | 4% | #6 | Tool-less design |
| GPU | 1% | #7 | Optional discrete GPU |

---

### 3. VIDEO EDITING BUILD

#### Best Performance (Fokus: Render Speed & Real-time Playback)
| Komponen | Persentase | Prioritas | Catatan |
|----------|-----------|-----------|---------|
| CPU | 35% | #1 | High core count (8+ cores) |
| RAM | 25% | #2 | 32GB minimum untuk timeline |
| GPU | 15% | #3 | CUDA/OpenCL acceleration |
| Storage | 15% | #4 | Fast NVMe untuk footage |
| Motherboard | 6% | #5 | Multiple M.2 slots |
| PSU | 3% | #6 | High wattage untuk stability |
| Casing | 1% | #7 | Good airflow |

#### Best Value (Fokus: Balanced Editing Performance)
| Komponen | Persentase | Prioritas | Catatan |
|----------|-----------|-----------|---------|
| CPU | 32% | #1 | 6-8 cores |
| RAM | 28% | #2 | 32GB DDR4 |
| Storage | 18% | #3 | 1TB NVMe |
| GPU | 12% | #4 | Mid-tier untuk preview |
| Motherboard | 6% | #5 | Dual M.2 support |
| PSU | 3% | #6 | 650W+ |
| Casing | 1% | #7 | Standard ATX |

#### Future Proof (Fokus: Professional Workflow)
| Komponen | Persentase | Prioritas | Catatan |
|----------|-----------|-----------|---------|
| CPU | 38% | #1 | 12+ cores, latest gen |
| RAM | 28% | #2 | 64GB DDR5 |
| Storage | 15% | #3 | Dual NVMe Gen4 |
| GPU | 10% | #4 | Professional GPU |
| Motherboard | 6% | #5 | Workstation grade |
| PSU | 2% | #6 | 80+ Platinum |
| Casing | 1% | #7 | Premium build |

---

## Aturan Kompatibilitas

### CPU & Motherboard
- **Intel:** LGA1700 (12th/13th gen), LGA1200 (10th/11th gen)
- **AMD:** AM5 (Ryzen 7000), AM4 (Ryzen 5000)
- Socket harus match

### RAM
- **DDR4:** Compatible dengan AM4, LGA1200, LGA1700 (tergantung board)
- **DDR5:** AM5, LGA1700 (Z690/B660+)
- Speed support sesuai CPU spec

### PSU Wattage Calculation
```
Total Wattage = (CPU TDP + GPU TDP + 100W overhead) × 1.2
Minimum: 450W untuk Office
Recommended Gaming: 650W-750W
High-end Editing: 750W-850W
```

### Storage
- Prioritas: NVMe Gen4 > NVMe Gen3 > SATA SSD > HDD
- OS Drive: SSD wajib
- Data/Media: HDD opsional untuk budget

### Case Size
- ATX Board → ATX/Mid Tower case
- Micro-ATX → Micro-ATX/Mid Tower
- Mini-ITX → Mini-ITX case

## Rekomendasi Budget Ranges

| Use Case | Budget Minimum | Budget Optimal | Budget Premium |
|----------|---------------|----------------|----------------|
| Office | Rp 5.000.000 | Rp 8.000.000 | Rp 12.000.000 |
| Gaming | Rp 10.000.000 | Rp 15.000.000 | Rp 25.000.000 |
| Editing | Rp 12.000.000 | Rp 20.000.000 | Rp 35.000.000 |
