<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Buku_model');
		$this->load->model('Petugas_model');
		if($this->session->userdata('logged_in') == false){
			redirect('welcome');
		}
	}

	public function index(){
		$data['title'] = 'Buku';
		$data['primary_view'] = 'buku/buku_view';
		$data['total'] = $this->Buku_model->getCount();
		$data['list'] = $this->Buku_model->getList();
		$this->load->view('template_view', $data);
	}

	public function add(){
		$data['title'] = 'Tambah Buku';
		$data['primary_view'] = 'buku/add_buku_view';
		$this->load->view('template_view', $data);
	}

	public function submit(){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('judul', 'Judul Buku', 'trim|required');
			$this->form_validation->set_rules('penulis', 'Penulis', 'trim|required');
			$this->form_validation->set_rules('penerbit', 'Penerbit', 'trim|required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'trim|required|numeric');
			$this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required|numeric');

			if ($this->form_validation->run() == true) {
				//GET : Petugas ID
				$username = $this->session->userdata('username');
				$id_petugas = $this->Petugas_model->getID($username);

				if($this->Buku_model->insert($id_petugas) == true){
					$this->session->set_flashdata('announce', 'Berhasil menyimpan data');
					redirect('buku/add');
				}else{
					$this->session->set_flashdata('announce', 'Gagal menyimpan data');
					redirect('buku/add');
				}
			} else {
				$this->session->set_flashdata('announce', validation_errors());
				redirect('buku/add');
			}
		}
	}

	public function submits(){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('judul', 'Judul Buku', 'trim|required');
			$this->form_validation->set_rules('penulis', 'Penulis', 'trim|required');
			$this->form_validation->set_rules('penerbit', 'Penerbit', 'trim|required');
			$this->form_validation->set_rules('tahun', 'Tahun', 'trim|required|numeric');
			$this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required|numeric');

			if ($this->form_validation->run() == true) {
				if($this->Buku_model->update($this->input->post('id')) == true){
					$this->session->set_flashdata('announce', 'Berhasil menyimpan data');
					redirect('buku/edit?idtf='.$this->input->post('id'));
				}else{
					$this->session->set_flashdata('announce', 'Gagal menyimpan data');
					redirect('buku/edit?idtf='.$this->input->post('id'));
				}
			} else {
				$this->session->set_flashdata('announce', validation_errors());
				redirect('buku/edit?idtf='.$this->input->post('id'));
			}
		}
	}

	public function edit(){
		$id = $this->input->get('idtf');
		//CHECK : Data Availability
		if($this->Buku_model->checkAvailability($id) == true){
			$data['primary_view'] = 'buku/edit_buku_view';
		}else{
			$data['primary_view'] = '404_view';
		}
		$data['title'] = 'Edit Buku';
		$data['detail'] = $this->Buku_model->getDetail($id);
		$this->load->view('template_view', $data);
	}

	public function delete(){
		$id = $this->input->get('rcgn');
		if($this->Buku_model->delete($id) == true){
			$this->session->set_flashdata('announce', 'Berhasil menghapus data');
			redirect('buku');
		}else{
			$this->session->set_flashdata('announce', 'Gagal menghapus data');
			redirect('buku');
		}
	}
public function label_buku()
{
    $this->load->library('pdf');

    $id = $this->input->get('idtf');
    if (!empty($id)) {
        $buku = $this->db->get_where('buku', ['ID_BUKU' => $id])->result();
    } else {
        $buku = $this->db->get('buku')->result();
    }

    // Ukuran label: 90mm x 40mm + margin 5mm (total 100x50 mm)
    $label_width = 90;
    $label_height = 40;
    $margin = 5;

    $pdf = new Pdf('L', 'mm', [$label_width + $margin * 2, $label_height + $margin * 2], true, 'UTF-8', false);
    $pdf->SetMargins($margin, $margin, $margin);
    $pdf->SetAutoPageBreak(false);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

	foreach ($buku as $b) {
		$pdf->AddPage();

		// 🔳 Background abu
		$pdf->SetFillColor(245, 245, 245);
		$pdf->Rect($margin, $margin, $label_width, $label_height, 'F');

		// 📌 Data Buku (kanan)
		$startX = $margin + 30;
		$startY = $margin + 5;
		$labelWidth = 20;
		$valueWidth = 35;
		$lineHeight = 6;

		$pdf->SetFont('helvetica', 'B', 9);
		$pdf->SetXY($startX, $startY);
		$pdf->Cell($labelWidth, $lineHeight, 'Kode', 0, 0, 'L');
		$pdf->Cell(2, $lineHeight, ':', 0, 0, 'L');
		$pdf->SetFont('helvetica', '', 9);
		$pdf->Cell($valueWidth, $lineHeight, $b->ID_BUKU, 0, 1, 'L');

		$pdf->SetFont('helvetica', '', 8);
		$pdf->SetX($startX);
		$pdf->Cell($labelWidth, $lineHeight, 'Judul', 0, 0, 'L');
		$pdf->Cell(2, $lineHeight, ':', 0, 0, 'L');
		$pdf->MultiCell($valueWidth, $lineHeight - 2, $b->TITLE, 0, 'L');

		$pdf->SetX($startX);
		$pdf->Cell($labelWidth, $lineHeight, 'Penulis', 0, 0, 'L');
		$pdf->Cell(2, $lineHeight, ':', 0, 0, 'L');
		$pdf->Cell($valueWidth, $lineHeight, $b->AUTHOR, 0, 1, 'L');

		$pdf->SetX($startX);
		$pdf->Cell($labelWidth, $lineHeight, 'Penerbit', 0, 0, 'L');
		$pdf->Cell(2, $lineHeight, ':', 0, 0, 'L');
		$pdf->Cell($valueWidth, $lineHeight, $b->PUBLISHER, 0, 1, 'L');

		$pdf->SetX($startX);
		$pdf->Cell($labelWidth, $lineHeight, 'Tahun', 0, 0, 'L');
		$pdf->Cell(2, $lineHeight, ':', 0, 0, 'L');
		$pdf->Cell($valueWidth, $lineHeight, $b->YEAR, 0, 1, 'L');

		// 🔲 QR Code (kiri)
		$qr_size = 26;
		$qr_x = $margin + 2;
		$qr_y = $margin + 7;
		$pdf->write2DBarcode($b->ID_BUKU, 'QRCODE,H', $qr_x, $qr_y, $qr_size, $qr_size);
	}

    // Hindari error output sebelum TCPDF
    ob_end_clean();

    $filename = !empty($id) ? 'label_buku_' . $id . '.pdf' : 'label_buku_semua.pdf';
    $pdf->Output($filename, 'D');
}


}

/* End of file Buku.php */
/* Location: ./application/controllers/Buku.php */