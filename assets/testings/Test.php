<?php

use PHPUnit\Framework\TestCase;

function mock_count_general_statistics($region) {
  $result = array();

  for ($i = 0; $i <count($region); $i++) { 
    $result["Общее количество потервпеших"] = $region["number_of_victims"];
    $result["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"] = $region["causes_of_crimes"];
    $result["Общее число нарушений УК РФ"] = $region["importance_of_the_statistical_factor"];
  }
  
  return $result;
}

function mock_count_general_statistics_percent($region) {
  $result = array();
  $total_count = 100000;

  for ($i = 0; $i <count($region); $i++) { 
    $result["Общее количество потервпеших"] = $region["number_of_victims"];
    $result["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"] = $region["causes_of_crimes"];
    $result["Общее число нарушений УК РФ"] = $region["importance_of_the_statistical_factor"];
  }

  foreach ($result as $key => $value) {
    $result[$key] = round($value / $total_count, 3) * 100;
}
  
  return $result;
}

class Test extends TestCase {
    public function test_count_general_statistics_1() {
      $region = [
        "number_of_victims" => 35000,
        "causes_of_crimes" => 50000,
        "importance_of_the_statistical_factor" => 100000,
      ];

      $data = mock_count_general_statistics($region);

      $this->assertEquals(35000, $data["Общее количество потервпеших"]);
      $this->assertEquals(50000, $data["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"]);
      $this->assertEquals(100000, $data["Общее число нарушений УК РФ"]);
    }

    public function test_count_general_statistics_2() {
      $region = [
        "number_of_victims" => 250000,
        "causes_of_crimes" => 500000,
        "importance_of_the_statistical_factor" => 450000,
      ];

      $data = mock_count_general_statistics($region);

      $this->assertEquals(250000, $data["Общее количество потервпеших"]);
      $this->assertEquals(500000, $data["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"]);
      $this->assertEquals(450000, $data["Общее число нарушений УК РФ"]);
    }

    public function test_count_general_statistics_percent_1() {
      $region = [
        "number_of_victims" => 10000,
        "causes_of_crimes" => 30000,
        "importance_of_the_statistical_factor" => 70000,
      ];

      $data = mock_count_general_statistics_percent($region);

      $this->assertEquals(10, $data["Общее количество потервпеших"]);
      $this->assertEquals(30, $data["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"]);
      $this->assertEquals(70, $data["Общее число нарушений УК РФ"]);
    }

    public function test_count_general_statistics_percent_2() {
      $region = [
        "number_of_victims" => 40000,
        "causes_of_crimes" => 50000,
        "importance_of_the_statistical_factor" => 10000,
      ];

      $data = mock_count_general_statistics_percent($region);

      $this->assertEquals(40, $data["Общее количество потервпеших"]);
      $this->assertEquals(50, $data["Алкогольные, токсические, наркотические опьянения или лица, ранее совершавшие преступления"]);
      $this->assertEquals(10, $data["Общее число нарушений УК РФ"]);
    }
}