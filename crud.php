<?php

$data = [];

function getInput($prompt, $isNumeric = False, $isUnique = False, $isGender = False)
{
    global $data;

    while (True) {
        echo $prompt;
        $input = trim(fgets(STDIN));
        if (empty($input)) {
            echo "Input tidak boleh kosong. Silahkan coba lagi.\n";
            continue;
        }
        if ($isNumeric && !is_numeric($input)) {
            echo "Input harus berupa angka. Silahkan coba lagi.\n";
            continue;
        }

        if ($isUnique) {
            if (!empty($data)) {
                if (in_array($input, array_column($data, 'nim'))) {
                    echo "NIM sudah ada. Silahkan masukkan NIM yang berbeda.\n";
                    continue;
                }
            }
        }

        if ($isGender) {
            if ($input != 'L' && $input != 'P') {
                echo "Jenis kelamin harus L atau P. Silahkan coba lagi.\n";
                continue;
            }
        }

        return $input;
    }
}

function table()
{
    global $data;

    if (!empty($data)) {
        // Header

        printf("%-5s | %-10s | %-5s | %-15s | %-10s | %-15s\n", "Index", "Nama", "Umur", "Jenis Kelamin", "NIM", "Fakultas");
        echo str_repeat("-", 80) . "\n";

        // Rows
        $x = 1;
        foreach ($data as $row) {
            $row['no'] = $x++;
            printf("%-5d | %-10s | %-5d | %-15s | %-10d | %-15s\n", $row['no'], $row['nama'], $row['umur'], $row['jenis_kelamin'], $row['nim'], $row['fakultas']);
        }
    } else {
        echo "Data kosong.\n";
    }
}

while (True) {
    echo <<< dap
    \n
        [1] Create
        [2] Read
        [3] Update
        [4] Delete
        [5] Exit
    \n
    dap;
    echo "Masukkan angka: ";
    $input = trim(fgets(STDIN));
    switch ($input) {
        case 1: //create
            $name = getInput("Nama: ");
            $age = getInput("Umur: ", True);
            $gender = getInput("Jenis Kelamin: ", False, False, True);
            $nim = getInput("NIM: ", True, True);
            $fakultas = getInput("Fakultas: ");

            $data[] = [
                'no' => count($data) + 1,
                'nama' => $name,
                'umur' => $age,
                'jenis_kelamin' => $gender,
                'nim' => $nim,
                'fakultas' => $fakultas,
            ];

            table();
            break;
        case 2: //read
            table();
            break;
        case 3: //update
            table();

            echo "Masukkan Index: ";
            $id = trim(fgets(STDIN));

            if (array_column($data, 'no')) {
                $name = getInput("Nama: ");
                $age = getInput("Umur: ", True);
                $gender = getInput("Jenis Kelamin: ", False, False, True);
                $nim = getInput("NIM: ", True, True);
                $fakultas = getInput("Fakultas: ");

                $data[array_search($id, array_column($data, 'no'))] = [
                    'no' => count($data) + 1,
                    'nama' => $name,
                    'umur' => $age,
                    'jenis_kelamin' => $gender,
                    'nim' => $nim,
                    'fakultas' => $fakultas,
                ];

                echo "Data berhasil diupdate...\n";
            } else {
                echo "Index tidak ditemukan...\n";
            }
            break;
        case 4: //delete
            table();

            echo "Masukkan Index: ";
            $id = trim(fgets(STDIN));

            if (array_column($data, 'no')) {

                unset($data[array_search($id, array_column($data, 'no'))]);

                echo "Data terhapus...";
            } else {
                echo "Index tidak ditemukan...\n";
            }
            break;
    }

    if ($input == 5) {
        echo "Bye (ʘᴥʘ)";
        break;
    }
}
