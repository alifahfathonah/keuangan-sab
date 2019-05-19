dH3*is32
SELECT id_batch FROM `v_batch_kelas` WHERE kategori='sd' and st_batch='t' and level in (1,2,3,6)

SELECT * FROM `t_batch_siswa` WHERE active=1 and id_batch in (SELECT id_batch FROM `v_batch_kelas` WHERE kategori='sd' and st_batch='t' and level in (1,2,3,6))

SELECT * FROM `t_tagihan_siswa` WHERE id_siswa in (SELECT id_siswa FROM `t_batch_siswa` WHERE active=1 and id_batch in (SELECT id_batch FROM `v_batch_kelas` WHERE kategori='sd' and st_batch='t' and level in (4,5)))

UPDATE `t_tagihan_siswa` set status_tagihan=1 WHERE status_tagihan=0 and id_siswa in (SELECT id_siswa FROM `t_batch_siswa` WHERE active=1 and id_batch in (SELECT id_batch FROM `v_batch_kelas` WHERE kategori='sd' and st_batch='t' and level in (4,5)))