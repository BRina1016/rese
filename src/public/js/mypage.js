document.addEventListener('DOMContentLoaded', function () {
    // お気に入り削除機能
    const heartIcons = document.querySelectorAll('.heart-icon');

    heartIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const storeId = this.getAttribute('data-store-id');
            const url = '/mypage/favorites';
            const method = 'DELETE';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ store_id: storeId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    const shopElement = this.closest('.shop');
                    if (shopElement) {
                        shopElement.remove();
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // 予約変更モーダル機能
    const modal = document.getElementById('editModal');
    const closeModal = document.querySelector('.close-modal');
    const editButtons = document.querySelectorAll('.edit-button');
    const editForm = document.getElementById('editReservationForm');
    const reservationIdField = document.getElementById('reservationId');
    const editDateField = document.getElementById('dateInput');
    const editHourField = document.getElementById('reservation_hour');
    const editMinuteField = document.getElementById('reservation_minute');
    const editNumberField = document.getElementById('number_of_people');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const reservationId = this.dataset.reservationId;

            // 編集データを取得してモーダルに反映
            fetch(`/reservation/${reservationId}/edit`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                reservationIdField.value = reservationId;
                editDateField.value = data.date;

                const timeParts = data.time.split(':');
                editHourField.value = timeParts[0];
                editMinuteField.value = timeParts[1];
                editNumberField.value = data.number_of_people;

                editForm.action = `/reservation/${reservationId}`; // 正しいURLを設定
                modal.style.display = 'block'; // モーダルを表示
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // モーダルを閉じる処理
    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});